import sys
import json
import itertools
import math
from collections import defaultdict, Counter

# ------------------------------------------------------------
# CONFIGURAÇÕES
# ------------------------------------------------------------
MAX_GAMES_PER_CARD = 5
MAX_CARDS_PER_CATEGORY = 10
MAX_USES_PER_GAME = 3

# 🔥 NOVO: Limites mínimos de probabilidade por nível
MIN_PROBABILITY = {
    "safe": 0.75,      # 75%
    "medium": 0.40,    # 40%
    "aggressive": 0.20 # 20%
}


def debug_input(games):
    return {
        "total_games": len(games),
        "sample_game": games[0] if games else None
    }


def group_markets(games):
    grouped = defaultdict(list)
    for g in games:
        game_id = g.get("game_id") or g.get("id")
        for m in g.get("markets", []):
            prob = max(0.01, min(0.99, float(m["probability"])))
            grouped[game_id].append({
                "game_id": game_id,
                "type": m["type"],
                "odd": float(m["odd"]),
                "prob": prob,
            })
    return list(grouped.values())


def select_top_with_limit(cards, category, n=10, max_uses=MAX_USES_PER_GAME):
    """Seleciona os melhores cards respeitando limite de uso e probabilidade mínima"""
    min_prob = MIN_PROBABILITY.get(category, 0.0)
    
    # Filtra apenas os que atendem o mínimo de probabilidade
    filtered = [card for card in cards if card["total_probability"] >= min_prob]
    
    selected = []
    game_usage = Counter()

    for card in sorted(filtered, key=lambda x: x["total_probability"], reverse=True):
        game_ids = [p["game_id"] for p in card["card"]]

        if all(game_usage[g] < max_uses for g in game_ids):
            selected.append(card)
            for g in game_ids:
                game_usage[g] += 1
            if len(selected) >= n:
                break
    return selected


def generate_cards(games):
    game_groups = group_markets(games)
    if not game_groups:
        return {"safe": [], "medium": [], "aggressive": []}

    results = {"safe": [], "medium": [], "aggressive": []}

    for r in range(2, min(MAX_GAMES_PER_CARD, len(game_groups)) + 1):
        for selected_groups in itertools.combinations(game_groups, r):
            for picks in itertools.product(*selected_groups):
                game_ids = [p["game_id"] for p in picks]
                if len(set(game_ids)) != len(picks):
                    continue

                total_odd = math.prod(p["odd"] for p in picks)
                total_prob = math.prod(p["prob"] for p in picks)
                total_prob = max(0.0, min(1.0, total_prob))

                card = {
                    "card": list(picks),
                    "total_odd": round(total_odd, 4),
                    "total_probability": round(total_prob, 6)
                }

                if 1.6 <= total_odd <= 2.5:
                    results["safe"].append(card)
                elif 2.6 <= total_odd <= 4.0:
                    results["medium"].append(card)
                elif 4.1 <= total_odd <= 6.0:
                    results["aggressive"].append(card)

                # Early stopping
                if all(len(results[k]) > MAX_CARDS_PER_CATEGORY for k in results):
                    break

    # Aplica filtros de probabilidade + limite de uso por categoria
    for category in results:
        results[category] = select_top_with_limit(
            results[category], 
            category=category, 
            n=10, 
            max_uses=MAX_USES_PER_GAME
        )

    return results


# ------------------------------------------------------------
# ENTRYPOINT
# ------------------------------------------------------------
if __name__ == "__main__":
    raw_input = sys.stdin.read().strip()

    try:
        games = json.loads(raw_input)
    except Exception as e:
        print(json.dumps({"error": "invalid_json", "message": str(e)}))
        sys.exit(1)

    debug = debug_input(games)
    output = generate_cards(games)

    response = {
        "debug": debug,
        "results": output
    }

    print(json.dumps(response))