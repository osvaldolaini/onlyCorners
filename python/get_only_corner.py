import sys
import json
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
# BUSCA ESTATÍSTICAS
# =========================
def get_statistics(page, event_id):
    url = f"https://api.sofascore.com/api/v1/event/{event_id}/statistics"
    return fetch_json(page, url)


# =========================
# EXTRAI ESCANTEIOS POR TEMPO
# =========================
def extract_corners_by_period(stats):
    result = {
        "home_first_half": 0,
        "away_first_half": 0,
        "home_second_half": 0,
        "away_second_half": 0,
        "home_total": 0,
        "away_total": 0
    }

    try:
        periods = stats.get("statistics", [])

        if not periods:
            return None

        for period_data in periods:
            period = period_data.get("period")

            for group in period_data.get("groups", []):
                for stat in group.get("statisticsItems", []):

                    if stat.get("key") == "cornerKicks":

                        home = int(stat.get("homeValue", 0))
                        away = int(stat.get("awayValue", 0))

                        if period == "1ST":
                            result["home_first_half"] = home
                            result["away_first_half"] = away

                        elif period == "2ND":
                            result["home_second_half"] = home
                            result["away_second_half"] = away

                        elif period == "ALL":
                            result["home_total"] = home
                            result["away_total"] = away

        # fallback
        if result["home_total"] == 0 and result["away_total"] == 0:
            result["home_total"] = result["home_first_half"] + result["home_second_half"]
            result["away_total"] = result["away_first_half"] + result["away_second_half"]

        return result

    except Exception as e:
        return {"error": str(e)}


# =========================
# PROCESSAMENTO PRINCIPAL
# =========================
def process_events(page, event_ids):
    results = []

    for event_id in event_ids:
        try:
            stats = get_statistics(page, event_id)

            # pequena pausa ajuda a evitar bloqueio
            page.wait_for_timeout(300)

            corners = extract_corners_by_period(stats)

            if corners and "error" not in corners:
                results.append({
                    "event_id": event_id,
                    **corners
                })
            else:
                results.append({
                    "event_id": event_id,
                    "error": "no_data"
                })

        except Exception as e:
            results.append({
                "event_id": event_id,
                "error": str(e)
            })

    return results


# =========================
# ENTRYPOINT (STDIN)
# =========================
if __name__ == "__main__":
    raw_input = sys.stdin.read().strip()

    try:
        data = json.loads(raw_input)

        if isinstance(data, int):
            event_ids = [data]
        elif isinstance(data, list):
            event_ids = data
        else:
            raise Exception("Formato inválido")

        with sync_playwright() as p:
            browser = p.chromium.launch(headless=True)

            context = browser.new_context(
                user_agent="Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
            )

            page = context.new_page()

            # 🔥 ESSENCIAL (gera cookies reais)
            page.goto("https://www.sofascore.com", wait_until="domcontentloaded")

            results = process_events(page, event_ids)

            browser.close()

        print(json.dumps({
            "success": True,
            "results": results
        }))

    except Exception as e:
        print(json.dumps({
            "success": False,
            "error": str(e)
        }))