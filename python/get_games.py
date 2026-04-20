import requests
import pandas as pd
import uuid
from datetime import datetime

HEADERS = {
    "User-Agent": "Mozilla/5.0"
}

# =========================
# CONFIGURE AQUI
# 🇧🇷 Brasileirão → 325
# 🇮🇹 Serie A (Itália) → 23
# 🇪🇸 La Liga → 8
# 🇬🇧 Premier League → 17
# FR League 1 → 34
# GR BundesLeague → 35
# =========================
TOURNAMENT_ID = 325  # 17 = Brasileirão | 23 = Itália

# =========================


def get_seasons():
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{TOURNAMENT_ID}/seasons"
    return requests.get(url, headers=HEADERS).json()["seasons"]


def get_rounds(season_id):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{TOURNAMENT_ID}/season/{season_id}/rounds"
    return requests.get(url, headers=HEADERS).json()["rounds"]


def get_matches(season_id, round_number):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{TOURNAMENT_ID}/season/{season_id}/events/round/{round_number}"
    return requests.get(url, headers=HEADERS).json().get("events", [])


def descobrir_rodada_atual(season_id, rounds):
    agora = datetime.now()

    rodada_atual = None
    melhor_data = None

    for r in rounds:
        matches = get_matches(season_id, r["round"])

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


def main():
    seasons = get_seasons()

    season_id = None

    for s in seasons:
        sid = s["id"]
        rounds = get_rounds(sid)

        if rounds:
            season_id = sid
            break

    if not season_id:
        print("❌ Nenhuma season encontrada")
        return

    print(f"Usando season {season_id}")

    rounds = get_rounds(season_id)

    current_round = descobrir_rodada_atual(season_id, rounds)

    if not current_round:
        print("❌ Não conseguiu determinar rodada atual")
        return

    next_round = current_round + 1

    print(f"Rodada atual: {current_round}")
    print(f"Próxima rodada: {next_round}")

    target_rounds = [current_round, next_round]

    dados = []

    for round_number in target_rounds:
        print(f"\n🔵 Rodada {round_number}")

        matches = get_matches(season_id, round_number)

        for match in matches:
            match_id = match["id"]

            home_team = match["homeTeam"]
            away_team = match["awayTeam"]

            home_id = home_team["id"]
            away_id = away_team["id"]

            home_name = home_team["name"]
            away_name = away_team["name"]

            timestamp = match.get("startTimestamp")

            if not timestamp:
                continue

            data_jogo = datetime.fromtimestamp(timestamp)
            date = data_jogo.strftime("%Y-%m-%d")
            hour = data_jogo.strftime("%H:%M:%S")

            print(f"  {home_name} x {away_name} ({date})")

            # 🔥 APENAS 1 LINHA POR JOGO
            dados.append({
                "id": match_id,
                "active": 1,
                "hour": hour,
                "date": date,
                "championship_id": TOURNAMENT_ID,
                "team_id": home_id,       # CASA
                "opponent_id": away_id,   # VISITANTE
                "code": str(uuid.uuid4())
            })

    df = pd.DataFrame(dados)

    if not df.empty:
        df.to_csv("next_rounds.csv", index=False)
        print("\n✅ CSV corrigido: next_rounds.csv")
    else:
        print("\n⚠️ Nenhum dado encontrado")


if __name__ == "__main__":
    main()