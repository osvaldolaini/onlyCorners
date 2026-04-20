<?php

namespace Modules\Prediction\App\Services;

use Modules\Corner\App\Models\Corner;
use Illuminate\Support\Collection;

class CornerStatsGamesService
{
    public function analyzeGames(Collection $games)
    {
        $predictions = [];

        $teamIds = $games
            ->flatMap(fn($g) => [$g->team_id, $g->opponent_id])
            ->unique();

        $corners = Corner::where(function ($q) use ($teamIds) {
            $q->whereIn('team_id', $teamIds)
                ->orWhereIn('opponent_id', $teamIds)
                ->orWhereIn('favored_id', $teamIds);
        })
            ->orderBy('date', 'desc')
            ->get();

        foreach ($games as $game) {

            $homeHistory = $this->getTeamHistory($corners, $game->team_id);
            $awayHistory = $this->getTeamHistory($corners, $game->opponent_id);

            // 🔥 MÉTRICAS PRINCIPAIS
            $homeAttack  = $this->weightedAverage($homeHistory, true, true);
            $homeDefense = $this->weightedAverage($homeHistory, true, false);

            $awayAttack  = $this->weightedAverage($awayHistory, false, true);
            $awayDefense = $this->weightedAverage($awayHistory, false, false);

            // 🔥 MÉTRICAS AVANÇADAS
            $homeAdvanced = $this->calculateAdvancedStats($homeHistory);
            $awayAdvanced = $this->calculateAdvancedStats($awayHistory);

            $homeExpected = ($homeAttack + $awayDefense) / 2;
            $awayExpected = ($awayAttack + $homeDefense) / 2;

            $total = $homeExpected + $awayExpected;

            $betType = $this->defineBetTypeMixed($total);

            $predictions[] = [
                'game_id' => $game->id,
                'home_team' => $game->team_id,
                'away_team' => $game->opponent_id,

                'total_corners' => round($total, 2),
                'bet' => $betType,

                'home_stats' => [
                    'attack' => round($homeAttack, 2),
                    'defense' => round($homeDefense, 2),
                ],
                'away_stats' => [
                    'attack' => round($awayAttack, 2),
                    'defense' => round($awayDefense, 2),
                ],

                'home_advanced' => $homeAdvanced,
                'away_advanced' => $awayAdvanced,
            ];
        }

        return $predictions;
    }

    private function calculateAdvancedStats(Collection $history)
    {
        if ($history->isEmpty()) {
            return [
                'home_home_avg' => 5.5,
                'home_away_avg' => 5.5,
                'recent_avg' => 5.5,
                'overall_avg' => 5.5,
            ];
        }

        $games = $history->map(fn($g) => $g['made'] + $g['conceded']);

        $homeGames = $history->where('is_home', true)
            ->map(fn($g) => $g['made'] + $g['conceded']);

        $awayGames = $history->where('is_home', false)
            ->map(fn($g) => $g['made'] + $g['conceded']);

        $recentGames = $games->take(5);

        return [
            'home_home_avg' => round($homeGames->avg() ?? 5.5, 2),
            'home_away_avg' => round($awayGames->avg() ?? 5.5, 2),
            'recent_avg' => round($recentGames->avg() ?? 5.5, 2),
            'overall_avg' => round($games->avg() ?? 5.5, 2),
        ];
    }

    private function getTeamHistory(Collection $corners, $teamId)
    {
        return $corners
            ->filter(
                fn($c) =>
                $c->team_id == $teamId ||
                    $c->opponent_id == $teamId ||
                    $c->favored_id == $teamId
            )
            ->groupBy(fn($c) => $c->game_id ?? $c->code)
            ->map(function ($gameCorners) use ($teamId) {

                $first = $gameCorners->first();

                $made = $gameCorners->where('favored_id', $teamId)->count();
                $total = $gameCorners->count();

                return [
                    'is_home' => $first->team_id == $teamId,
                    'made' => $made,
                    'conceded' => $total - $made,
                    'date' => $first->date,
                ];
            })
            ->sortByDesc('date')
            ->values()
            ->take(15);
    }

    private function weightedAverage(Collection $games, bool $isHomeUpcoming, bool $isAttack)
    {
        if ($games->isEmpty()) return 5.5;

        $sum = 0;
        $weightTotal = 0;

        foreach ($games as $i => $g) {

            $mando = $isHomeUpcoming
                ? ($g['is_home'] ? 2 : 1)
                : ($g['is_home'] ? 1 : 2);

            $recent = $i < 5 ? 2 : 1;

            $weight = $mando * $recent;

            $value = $isAttack ? $g['made'] : $g['conceded'];

            $sum += $value * $weight;
            $weightTotal += $weight;
        }

        return $sum / $weightTotal;
    }

    private function defineBetTypeMixed($total)
    {
        if ($total >= 10.7) return 'over_10_5';
        if ($total >= 10.0) return 'over_9_5';
        if ($total >= 9.0) return 'over_8_5';
        if ($total >= 8.0) return 'under_10_5';

        return 'under_9_5';
    }
}
