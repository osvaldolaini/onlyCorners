<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Modules\Championship\App\Models\Championship;
use Modules\Corner\App\Models\Corner;
use Modules\Game\App\Models\Game;
use Modules\Prediction\App\Models\Prediction;

class DetailPageCharts extends Component
{
    // Define o layout a ser usado
    protected $layout = 'page';
    public $bets = [];

    public $labelsLeague;
    public $avgAllLeague;
    public $avgLast5League;

    public $labelsHalf;
    public $firstHalf;
    public $secondHalf;

    public function render()
    {
        $this->chartByLeagueHalf();
        $this->chartByLeague();
        return view('livewire.page.detail-page-charts')->layout('layouts.' . $this->layout);
    }


    public function chartByLeague()
    {
        $labels = [];
        $avgAll = [];
        $avgLast5 = [];

        $leagues = Game::select('championship_id')
            ->distinct()
            ->pluck('championship_id');

        foreach ($leagues as $league) {

            $games = Game::where('championship_id', $league)
                ->withCount('corners')
                ->having('corners_count', '>', 0) // 🔥 AQUI MUDA TUDO
                ->get();

            if ($games->count() == 0) continue;

            $mediaAll = $games->avg('corners_count');

            $last5 = Game::where('championship_id', $league)
                ->withCount('corners')
                ->having('corners_count', '>', 0)
                ->orderByDesc('date')
                ->orderByDesc('hour')
                ->take(5)
                ->get();

            if ($last5->count() == 0) continue;

            $mediaLast5 = $last5->avg('corners_count');


            $labels[] = Championship::where('sofascore_id', $league)->first()->nick;
            $avgAll[] = round($mediaAll, 2);
            $avgLast5[] = round($mediaLast5, 2);
        }

        // 🔥 DEBUG FINAL
        // dd($labels, $avgAll, $avgLast5);

        $this->labelsLeague = $labels;
        $this->avgAllLeague = $avgAll;
        $this->avgLast5League = $avgLast5;
    }

    public function chartByLeagueHalf()
    {
        $labels = [];
        $firstHalf = [];
        $secondHalf = [];

        $leagues = Game::select('championship_id')
            ->distinct()
            ->pluck('championship_id');

        foreach ($leagues as $league) {

            // jogos da liga
            $games = Game::where('championship_id', $league)
                ->pluck('id');

            if ($games->isEmpty()) continue;

            // total de escanteios 1º tempo
            $first = Corner::whereIn('game_id', $games)
                ->where('half', 'first')
                ->count();

            // total de escanteios 2º tempo
            $second = Corner::whereIn('game_id', $games)
                ->where('half', 'second')
                ->count();

            $totalGames = $games->count();

            if ($totalGames == 0) continue;

            // 🔥 média por jogo
            $mediaFirst = $first / $totalGames;
            $mediaSecond = $second / $totalGames;


            $labels[] = Championship::where('sofascore_id', $league)->first()->nick;
            $firstHalf[] = round($mediaFirst, 2);
            $secondHalf[] = round($mediaSecond, 2);
        }

        $this->labelsHalf = $labels;
        $this->firstHalf = $firstHalf;
        $this->secondHalf = $secondHalf;
        // dd($this->labelsHalf, $this->firstHalf, $this->secondHalf);
    }
}
