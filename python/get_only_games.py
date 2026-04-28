import sys
import json
from datetime import datetime
from playwright.sync_api import sync_playwright


# =========================
# FETCH VIA BROWSER
# =========================
def fetch_json(page, url):
    try:
        response = page.goto(url, wait_until="networkidle")
        text = response.text()
        return json.loads(text)
    except:
        return {}


# =========================
# API CALLS
# =========================
def get_seasons(page, tournament_id):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{tournament_id}/seasons"
    return fetch_json(page, url).get("seasons", [])


def get_rounds(page, tournament_id, season_id):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{tournament_id}/season/{season_id}/rounds"
    return fetch_json(page, url).get("rounds", [])


def get_matches(page, tournament_id, season_id, round_number):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{tournament_id}/season/{season_id}/events/round/{round_number}"
    return fetch_json(page, url).get("events", [])


# =========================
# DESCOBRE PRÓXIMA RODADA
# =========================
def get_next_round(page, tournament_id, season_id, rounds):
    agora = datetime.now()

    candidata = None
    menor_data = None

    for r in rounds:
        round_number = r["round"]

        matches = get_matches(page, tournament_id, season_id, round_number)

        if not matches:
            continue

        datas = [
            datetime.fromtimestamp(m["startTimestamp"])
            for m in matches if m.get("startTimestamp")
        ]

        if not datas:
            continue

        primeira_data = min(datas)

        if primeira_data > agora:
            if not menor_data or primeira_data < menor_data:
                menor_data = primeira_data
                candidata = round_number

    return candidata


# =========================
# FORMATAR DADOS
# =========================
def format_matches(matches, round_number):
    dados = []

    for match in matches:
        timestamp = match.get("startTimestamp")

        if not timestamp:
            continue

        home = match["homeTeam"]
        away = match["awayTeam"]

        data_jogo = datetime.fromtimestamp(timestamp)

        dados.append({
            "event_id": match["id"],
            "round": round_number,
            "date": data_jogo.strftime("%Y-%m-%d"),
            "hour": data_jogo.strftime("%H:%M:%S"),
            "home_team_id": home["id"],
            "away_team_id": away["id"],
            "home_name": home["name"],
            "away_name": away["name"],
        })

    return dados


# =========================
# MAIN
# =========================
def main():
    raw_input = sys.stdin.read().strip()

    try:
        tournament_id = int(raw_input)

        with sync_playwright() as p:
            browser = p.chromium.launch(headless=True)

            context = browser.new_context(
                user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
            )

            page = context.new_page()

            # 🔥 abre o site antes (ESSENCIAL)
            page.goto("https://www.sofascore.com", wait_until="domcontentloaded")

            # 1. seasons
            seasons = get_seasons(page, tournament_id)

            if not seasons:
                raise Exception("Nenhuma season encontrada")

            season_id = seasons[0]["id"]

            # 2. rounds
            rounds = get_rounds(page, tournament_id, season_id)

            if not rounds:
                raise Exception("Nenhuma rodada encontrada")

            # 3. próxima rodada
            next_round = get_next_round(page, tournament_id, season_id, rounds)

            if not next_round:
                raise Exception("Próxima rodada não encontrada")

            current_round = next_round - 1

            dados = []

            # 4. jogos
            for r in [current_round, next_round]:
                matches = get_matches(page, tournament_id, season_id, r)
                dados.extend(format_matches(matches, r))

            browser.close()

        print(json.dumps({
            "success": True,
            "current_round": current_round,
            "next_round": next_round,
            "total_games": len(dados),
            "results": dados
        }))

    except Exception as e:
        print(json.dumps({
            "success": False,
            "error": str(e)
        }))


if __name__ == "__main__":
    main()