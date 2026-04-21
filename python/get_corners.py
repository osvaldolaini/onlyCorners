import requests
import pandas as pd
import time
from datetime import datetime

agora = datetime.now()

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

# =========================
# CONFIGURE AQUI
# =========================
START_DATE = "2026-01-01"
END_DATE = "2026-12-31"
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


def get_statistics(event_id):
    url = f"https://api.sofascore.com/api/v1/event/{event_id}/statistics"
    return requests.get(url, headers=HEADERS).json()


def extract_corners(stats):
    try:
        groups = stats.get("statistics", [])

        for group in groups:
            for item in group.get("groups", []):
                for stat in item.get("statisticsItems", []):

                    name = stat.get("name", "").lower()

                    if name == "corner kicks":
                        return {
                            "home": int(stat.get("home", 0)),
                            "away": int(stat.get("away", 0))
                        }

    except:
        pass

    return None


def dentro_intervalo(timestamp):
    data_jogo = datetime.fromtimestamp(timestamp).date()
    start = datetime.strptime(START_DATE, "%Y-%m-%d").date()
    end = datetime.strptime(END_DATE, "%Y-%m-%d").date()
    return start <= data_jogo <= end


def main():
    seasons = get_seasons()

    season_id = None

    for s in seasons:
        sid = s["id"]
        rounds = get_rounds(sid)

        if len(rounds) > 0:
            season_id = sid
            break

    print(f"Usando season {season_id}")

    rounds = get_rounds(season_id)

    resumo = []
    detalhado = []

    stop = False
    for r in rounds:
        round_number = r["round"]

        print(f"\nRodada {round_number}")

        matches = get_matches(season_id, round_number)

        for match in matches:
            timestamp = match.get("startTimestamp")

            if not timestamp or not dentro_intervalo(timestamp):
                continue

            match_id = match["id"]

            # 🔥 SLUG + ID
            home_team = match["homeTeam"]["slug"]
            away_team = match["awayTeam"]["slug"]

            home_id = match["homeTeam"]["id"]
            away_id = match["awayTeam"]["id"]

            data_jogo = datetime.fromtimestamp(timestamp)
            data_formatada = data_jogo.strftime("%Y-%m-%d")
            hora_formatada = data_jogo.strftime("%H:%M:%S")

            print(f"  Processando {home_team} x {away_team} ({data_formatada})")

            # 🔥 SE O JOGO FOR NO FUTURO → PARA TUDO
            if data_jogo > agora:
                print(f"⛔ Parando: jogo futuro encontrado ({data_formatada})")
                stop = True
                break

            stats = get_statistics(match_id)
            corners = extract_corners(stats)

            if corners:
                home_corners = corners["home"]
                away_corners = corners["away"]

                print(f"    ✔ {home_corners} x {away_corners}")

                # =========================
                # CSV 1 (RESUMO)
                # =========================
                resumo.append({
                    "game_id": match_id,
                    "date": data_formatada,
                    "hour": hora_formatada,
                    "home_team": home_team,
                    "home_team_id": home_id,
                    "away_team": away_team,
                    "away_team_id": away_id,
                    "home_corners": home_corners,
                    "away_corners": away_corners
                })

                # =========================
                # CSV 2 (DETALHADO)
                # =========================

                # Casa
                for i in range(home_corners):
                    detalhado.append({
                        "game_id": match_id,
                        "date": data_formatada,
                        "hour": hora_formatada,
                        "team_id": home_team,
                        "team_sofascore_id": home_id,
                        "opponent_id": away_team,
                        "opponent_sofascore_id": away_id,
                        "favored_id": home_team,
                        "favored_sofascore_id": home_id
                    })

                # Visitante
                for i in range(away_corners):
                    detalhado.append({
                        "game_id": match_id,
                        "date": data_formatada,
                        "hour": hora_formatada,
                        "team_id": home_team,
                        "team_sofascore_id": home_id,
                        "opponent_id": away_team,
                        "opponent_sofascore_id": away_id,
                        "favored_id": away_team,
                        "favored_sofascore_id": away_id
                    })

            else:
                print(f"    ❌ sem dados")

            time.sleep(0.3)

    # =========================
    # SALVAR CSVs
    # =========================

    df_resumo = pd.DataFrame(resumo)
    df_detalhado = pd.DataFrame(detalhado)

    if not df_resumo.empty:
        df_resumo.to_csv("corners_resumo.csv", index=False)
        print("\n✅ corners_resumo.csv criado")

    if not df_detalhado.empty:
        df_detalhado.to_csv("corners_detalhado.csv", index=False)
        print("✅ corners_detalhado.csv criado")

    if df_resumo.empty and df_detalhado.empty:
        print("\n⚠️ Nenhum dado encontrado")


if __name__ == "__main__":
    main()