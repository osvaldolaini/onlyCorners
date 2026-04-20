import sys
import json
import itertools
import math
from collections import defaultdict


# ------------------------------------------------------------
# 🔎 DEBUG: mostra como os dados chegam do Laravel
# ------------------------------------------------------------
def debug_input(games):
    return {
        "total_games": len(games),
        "sample_game": games[0] if games else None
    }


# ------------------------------------------------------------
# 🧠 AGRUPA POR JOGO (evita combinações inválidas e explosão)
# ------------------------------------------------------------
def group_markets(games):

    grouped = defaultdict(list)

    for g in games:
        game_id = g["game_id"]

        for m in g["markets"]:

            prob = float(m["probability"])
            # explanation = g["explanation"]

            # 🔥 evita probabilidade inválida ou saturada
            prob = max(0.01, min(0.99, prob))

            grouped[game_id].append({
                "game_id": game_id,
                "type": m["type"],
                "odd": float(m["odd"]),
                "prob": prob,
                # "explication":explanation
            })

    return list(grouped.values())


# ------------------------------------------------------------
# 🎯 GERA CARDS (SAFE / MEDIUM / AGGRESSIVE)
# ------------------------------------------------------------
def generate_cards(games):

    game_groups = group_markets(games)

    results = {
        "safe": [],
        "medium": [],
        "aggressive": []
    }

    # 🔥 evita explosão combinatória
    max_games = min(7, len(game_groups))

    for r in range(2, max_games + 1):

        for selected_games in itertools.combinations(game_groups, r):

            # produto cartesiano (1 mercado por jogo)
            for picks in itertools.product(*selected_games):

                game_ids = [p["game_id"] for p in picks]

                # garante 1 mercado por jogo
                if len(set(game_ids)) != len(game_ids):
                    continue

                total_odd = math.prod(p["odd"] for p in picks)
                total_prob = math.prod(p["prob"] for p in picks)

                # 🔥 segurança matemática
                total_prob = max(0.0, min(1.0, total_prob))

                card = {
                    "card": list(picks),
                    "total_odd": round(total_odd, 4),
                    "total_probability": round(total_prob, 6)
                }

                # 📊 classificação dos cards
                if 1.6 <= total_odd <= 2.5:
                    results["safe"].append(card)

                elif total_odd <= 4:
                    results["medium"].append(card)

                elif total_odd <= 6:
                    results["aggressive"].append(card)

    # 🔝 ordena por melhor probabilidade e limita TOP 10
    for k in results:
        results[k] = sorted(
            results[k],
            key=lambda x: x["total_probability"],
            reverse=True
        )[:10]

    return results


# ------------------------------------------------------------
# 🚀 ENTRYPOINT
# ------------------------------------------------------------
if __name__ == "__main__":

    raw_input = sys.stdin.read()

    # ❌ valida JSON
    try:
        games = json.loads(raw_input)
    except Exception as e:
        print(json.dumps({
            "error": "invalid_json",
            "message": str(e),
            "raw_preview": raw_input[:300]
        }))
        sys.exit(1)

    # 🔎 debug input
    debug = debug_input(games)

    # 🎯 processamento principal
    output = generate_cards(games)

    # 📦 resposta final estruturada
    response = {
        "debug": debug,
        "results": output
    }

    print(json.dumps(response))