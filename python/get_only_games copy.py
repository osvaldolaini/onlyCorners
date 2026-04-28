import sys
import json
import requests
import uuid
from datetime import datetime

HEADERS = {
    "User-Agent": "Mozilla/5.0",
    "Accept": "application/json",
    "Referer": "https://www.sofascore.com/"
}


# =========================
# API CALLS
# =========================
def get_seasons(tournament_id):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{tournament_id}/seasons"
    return requests.get(url, headers=HEADERS).json().get("seasons", [])


def get_rounds(tournament_id, season_id):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{tournament_id}/season/{season_id}/rounds"
    return requests.get(url, headers=HEADERS).json().get("rounds", [])


def get_matches(tournament_id, season_id, round_number):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{tournament_id}/season/{season_id}/events/round/{round_number}"
    return requests.get(url, headers=HEADERS).json().get("events", [])


# =========================
# DESCOBRE RODADA ATUAL
# =========================
def descobrir_rodada_atual(tournament_id, season_id, rounds):
    agora = datetime.now()

    rodada_atual = None
    melhor_data = None

    for r in rounds:
        matches = get_matches(tournament_id, season_id, r["round"])

        if not matches:
            continue

        datas = [
            datetime.fromtimestamp(m["startTimestamp"])
            for m in matches if m.get("startTimestamp")
        ]

        if not datas:
            continue

        data_inicio = min(datas)

        if data_inicio <= agora:
            if not melhor_data or data_inicio > melhor_data:
                melhor_data = data_inicio
                rodada_atual = r["round"]

    return rodada_atual


# =========================
# MAIN
# =========================
def main():
    raw_input = sys.stdin.read().strip()

    try:
        tournament_id = int(raw_input)

        # seasons = get_seasons(tournament_id)
        seasons = get_seasons(tournament_id)

        if not seasons:
            raise Exception("Nenhuma season encontrada")

        # pega a primeira válida
        season_id = None
        for s in seasons:
            sid = s["id"]
            rounds = get_rounds(tournament_id, sid)

            if rounds:
                season_id = sid
                break

        if not season_id:
            raise Exception("Season inválida")

        rounds = get_rounds(tournament_id, season_id)

        current_round = descobrir_rodada_atual(tournament_id, season_id, rounds)

        if not current_round:
            raise Exception("Não encontrou rodada atual")

        next_round = current_round + 1

        target_rounds = [current_round, next_round]

        dados = []

        for round_number in target_rounds:
            matches = get_matches(tournament_id, season_id, round_number)

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

        print(json.dumps({
            "success": True,
            "current_round": current_round,
            "next_round": next_round,
            "results": dados
        }))

    except Exception as e:
        print(json.dumps({
            "success": False,
            "error": str(e)
        }))


if __name__ == "__main__":
    main()