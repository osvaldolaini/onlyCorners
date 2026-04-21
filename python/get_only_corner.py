import sys
import json
import requests

HEADERS = {
    "User-Agent": "Mozilla/5.0"
}


# =========================
# BUSCA ESTATÍSTICAS
# =========================
def get_statistics(event_id):
    url = f"https://api.sofascore.com/api/v1/event/{event_id}/statistics"
    response = requests.get(url, headers=HEADERS, timeout=10)
    return response.json()


# =========================
# EXTRAI ESCANTEIOS
# =========================
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

    except Exception as e:
        return {"error": str(e)}

    return None


# =========================
# PROCESSAMENTO PRINCIPAL
# =========================
def process_events(event_ids):
    results = []

    for event_id in event_ids:
        try:
            stats = get_statistics(event_id)
            corners = extract_corners(stats)

            if corners:
                results.append({
                    "event_id": event_id,
                    "home_corners": corners["home"],
                    "away_corners": corners["away"]
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

        # aceita:
        # 1 -> único id
        # [1,2,3] -> vários ids
        if isinstance(data, int):
            event_ids = [data]
        elif isinstance(data, list):
            event_ids = data
        else:
            raise Exception("Formato inválido")

        results = process_events(event_ids)

        print(json.dumps({
            "success": True,
            "results": results
        }))

    except Exception as e:
        print(json.dumps({
            "success": False,
            "error": str(e)
        }))