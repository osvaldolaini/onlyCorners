import sys
import json
import csv
import uuid
from datetime import datetime
from playwright.sync_api import sync_playwright

OUTPUT_FILE = "corners.csv"


def fetch_json(page, url):
    response = page.request.get(url)
    if response.status != 200:
        return None
    return response.json()


def extract_corners(stats):
    result = {
        "home_first": 0,
        "away_first": 0,
        "home_second": 0,
        "away_second": 0,
    }

    for period_data in stats.get("statistics", []):
        period = period_data.get("period")

        for group in period_data.get("groups", []):
            for stat in group.get("statisticsItems", []):

                if stat.get("key") == "cornerKicks":
                    home = int(stat.get("homeValue", 0))
                    away = int(stat.get("awayValue", 0))

                    if period == "1ST":
                        result["home_first"] = home
                        result["away_first"] = away

                    elif period == "2ND":
                        result["home_second"] = home
                        result["away_second"] = away

    return result


def write_rows(writer, game_id, team_id, opponent_id, league_id, date, hour, corners):
    
    def create(count, favored_id, half):
        for _ in range(count):
            writer.writerow({
                "game_id": game_id,
                "team_id": team_id,
                "opponent_id": opponent_id,
                "favored_id": favored_id,
                "half": half,
                "championship_id": league_id,
                "date": date,
                "hour": hour,
                "code": str(uuid.uuid4())
            })

    # casa
    create(corners["home_first"], team_id, "first")
    create(corners["home_second"], team_id, "second")

    # visitante
    create(corners["away_first"], opponent_id, "first")
    create(corners["away_second"], opponent_id, "second")


def main():
    raw_input = sys.stdin.read().strip()

    try:
        data = json.loads(raw_input)

        if not isinstance(data, list):
            raise Exception("Esperado lista de IDs")

        with sync_playwright() as p:
            browser = p.chromium.launch(headless=True)
            context = browser.new_context()
            page = context.new_page()

            with open(OUTPUT_FILE, mode="w", newline="", encoding="utf-8") as file:
                writer = csv.DictWriter(file, fieldnames=[
                    "game_id",
                    "team_id",
                    "opponent_id",
                    "favored_id",
                    "half",
                    "championship_id",
                    "date",
                    "hour",
                    "code"
                ])
                writer.writeheader()

                for i, event_id in enumerate(data):
                    try:
                        stats = fetch_json(
                            page,
                            f"https://api.sofascore.com/api/v1/event/{event_id}/statistics"
                        )

                        if not stats:
                            continue

                        # ⚠️ aqui você não tem info do jogo (team/date/etc)
                        # então buscamos o evento
                        event = fetch_json(
                            page,
                            f"https://api.sofascore.com/api/v1/event/{event_id}"
                        )

                        if not event:
                            continue

                        event = event.get("event", {})

                        timestamp = event.get("startTimestamp")
                        if not timestamp:
                            continue

                        dt = datetime.fromtimestamp(timestamp)

                        team_id = event["homeTeam"]["id"]
                        opponent_id = event["awayTeam"]["id"]
                        league_id = event["tournament"]["uniqueTournament"]["id"]

                        corners = extract_corners(stats)

                        write_rows(
                            writer,
                            event_id,
                            team_id,
                            opponent_id,
                            league_id,
                            dt.strftime("%Y-%m-%d"),
                            dt.strftime("%H:%M:%S"),
                            corners
                        )

                        if i % 20 == 0:
                            print(f"Processados: {i}/{len(data)}")

                    except Exception as e:
                        print(f"Erro {event_id}: {e}")

            browser.close()

        print("✅ CSV gerado: corners.csv")

    except Exception as e:
        print(f"Erro geral: {e}")


if __name__ == "__main__":
    main()