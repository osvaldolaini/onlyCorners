import sys
import json
import requests

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
    "Accept": "application/json, text/plain, */*",
    "Origin": "https://www.sofascore.com",
    "Referer": "https://www.sofascore.com/",
}

def get_tournaments_by_category(category_id):
    try:
        url = f"https://api.sofascore.com/api/v1/category/{category_id}/unique-tournaments"
        response = requests.get(url, headers=HEADERS)

        if response.status_code != 200:
            return {
                "success": False,
                "error": f"HTTP {response.status_code}",
                "body": response.text[:200]  # debug
            }

        data = response.json()

        tournaments = []

        for group in data.get("groups", []):
            for t in group.get("uniqueTournaments", []):
                tournaments.append({
                    "id": t.get("id"),
                    "name": t.get("name"),
                    "slug": t.get("slug")
                })

        return {
            "success": True,
            "total": len(tournaments),
            "tournaments": tournaments
        }

    except Exception as e:
        return {
            "success": False,
            "error": str(e)
        }


def main():
    # pega argumento direto do terminal
    if len(sys.argv) < 2:
        print(json.dumps({
            "success": False,
            "error": "Informe o category_id. Ex: python script.py 13"
        }))
        return

    category_id = sys.argv[1]

    if not category_id.isdigit():
        print(json.dumps({
            "success": False,
            "error": "Formato inválido"
        }))
        return

    result = get_tournaments_by_category(category_id)

    print(json.dumps(result, ensure_ascii=False, indent=2))


if __name__ == "__main__":
    main()