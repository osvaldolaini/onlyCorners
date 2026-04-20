import requests
import pandas as pd
import unicodedata

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
COUNTRY = "Brasil"
# =========================


def get_seasons():
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{TOURNAMENT_ID}/seasons"
    return requests.get(url, headers=HEADERS).json()["seasons"]


def get_standings(season_id):
    url = f"https://api.sofascore.com/api/v1/unique-tournament/{TOURNAMENT_ID}/season/{season_id}/standings/total"
    return requests.get(url, headers=HEADERS).json()


def limpar_texto(texto):
    return ''.join(
        c for c in unicodedata.normalize('NFD', texto)
        if unicodedata.category(c) != 'Mn'
    )


def gerar_nick(name):
    name = limpar_texto(name).upper()

    remover = [
        "CLUBE", "CLUB", "FC", "AC", "SC", "EC",
        "ASSOCIACAO", "ASSOCIAÇÃO", "DE", "DA", "DO", "THE"
    ]

    palavras = name.split()
    palavras_filtradas = [p for p in palavras if p not in remover]

    return " ".join(palavras_filtradas)


def gerar_title(name):
    # 🔥 agora é o nome real (sem forçar CLUBE)
    return limpar_texto(name).upper()


def main():
    seasons = get_seasons()
    season_id = seasons[0]["id"]

    print(f"Usando season {season_id}")

    data = get_standings(season_id)

    teams = []

    rows = data["standings"][0]["rows"]

    for row in rows:
        team = row["team"]

        original_name = team["name"]
        slug = team["slug"]
        sofascore_id = team["id"]

        title = gerar_title(original_name)
        nick = gerar_nick(original_name)

        teams.append({
            "sofascore_id": sofascore_id,
            "slug": 'only-corners-'+slug,
            "title": title,
            "nick": nick,
            "country": COUNTRY
        })

        print(f"{original_name} → {title} | {nick}")

    df = pd.DataFrame(teams, columns=[
        "sofascore_id",
        "slug",
        "title",
        "nick",
        "country"
    ])

    df.to_csv("teams_formatted.csv", index=False)

    print("\n✅ teams_formatted.csv criado")


if __name__ == "__main__":
    main()