from playwright.sync_api import sync_playwright
import csv
import uuid
from datetime import datetime

LEAGUES = [8, 17, 23, 34, 35, 325]
OUTPUT_FILE = "corners.csv"


def fetch_json(page, url):
    response = page.request.get(url)

    if response.status != 200:
        return None

    return response.json()


def get_current_season(seasons):
    seasons_sorted = sorted(seasons, key=lambda x: x["id"], reverse=True)

    for s in seasons_sorted:
        if "20" in str(s.get("year", "")):
            return s["id"]

    return seasons_sorted[0]["id"]


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


def main():
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

            for league in LEAGUES:
                print(f"\n🔍 Liga {league}")

                seasons_data = fetch_json(
                    page,
                    f"https://api.sofascore.com/api/v1/unique-tournament/{league}/seasons"
                )

                if not seasons_data:
                    continue

                seasons = seasons_data.get("seasons", [])
                if not seasons:
                    continue

                season_id = get_current_season(seasons)

                rounds_data = fetch_json(
                    page,
                    f"https://api.sofascore.com/api/v1/unique-tournament/{league}/season/{season_id}/rounds"
                )

                if not rounds_data:
                    continue

                rounds = rounds_data.get("rounds", [])

                for r in rounds:
                    round_number = r["round"]

                    events_data = fetch_json(
                        page,
                        f"https://api.sofascore.com/api/v1/unique-tournament/{league}/season/{season_id}/events/round/{round_number}"
                    )

                    if not events_data:
                        continue

                    events = events_data.get("events", [])

                    print(f"Rodada {round_number} → {len(events)} jogos")

                    for match in events:
                        try:
                            timestamp = match.get("startTimestamp")

                            if not timestamp or timestamp < 1000000000:
                                continue

                            stats = fetch_json(
                                page,
                                f"https://api.sofascore.com/api/v1/event/{match['id']}/statistics"
                            )

                            if not stats:
                                continue

                            corners = extract_corners(stats)

                            dt = datetime.fromtimestamp(timestamp)

                            game_id = match["id"]
                            team_id = match["homeTeam"]["id"]
                            opponent_id = match["awayTeam"]["id"]

                            def write_rows(count, favored_id, half):
                                for _ in range(count):
                                    writer.writerow({
                                        "game_id": game_id,
                                        "team_id": team_id,
                                        "opponent_id": opponent_id,
                                        "favored_id": favored_id,
                                        "half": half,
                                        "championship_id": league,
                                        "date": dt.strftime("%Y-%m-%d"),
                                        "hour": dt.strftime("%H:%M:%S"),
                                        "code": str(uuid.uuid4())
                                    })

                            # CASA
                            write_rows(corners["home_first"], team_id, "first")
                            write_rows(corners["home_second"], team_id, "second")

                            # VISITANTE
                            write_rows(corners["away_first"], opponent_id, "first")
                            write_rows(corners["away_second"], opponent_id, "second")

                        except Exception as e:
                            print(f"Erro jogo {match['id']}: {e}")

        browser.close()

    print("\n✅ CSV de escanteios gerado!")


if __name__ == "__main__":
    main()