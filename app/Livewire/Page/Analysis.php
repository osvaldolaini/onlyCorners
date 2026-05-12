<?php

namespace App\Livewire\Page;

use Livewire\Component;

use App\Services\LaiGuz\TableService;

use Livewire\WithPagination;

use Modules\Championship\App\Models\Championship;
use Modules\Corner\App\Models\Corner;
use Modules\Game\App\Models\Game;

class Analysis extends Component
{
    // Define o layout a ser usado
    protected $layout = 'page';

    use WithPagination;
    public $breadcrumb = 'Jogos do dia';
    public $modal = false;
    public $showModalShow = false;

    public $rules;
    public $detail;
    public $games;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "Modules\Game\App\Models\Game"; //Model principal
    public $modelId = "games.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['games.date' => 'desc', 'games.hour' => 'asc'];
    public $relationTables =  "teams,teams.id,games.team_id | championships,championships.id,games.championship_id";
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'games.date,games.hour,games.opponent_id,games.team_id,games.championship_id,championships.logo_path,championships.nick,teams.logo_path,teams.nick,games.active as status';
    public $searchable = 'teams.nick,games.date'; //Colunas pesquisadas no banco de dados

    public $paginate = 50; //Qtd de registros por página
    public $active = 'games.active';


    public $labelsLeague;
    public $avgAllLeague;
    public $avgLast5League;

    public $labelsHalf;
    public $firstHalf;
    public $secondHalf;


    public function render(TableService $queryService)
    {
        $this->chartByLeagueHalf();
        $this->chartByLeague();

        if (date('H:i') > '20:00') {
            $d = date('Y-m-d', strtotime('+1 day'));
        } else {
            $d = date('Y-m-d');
        }


        $dataTable = $queryService
            ->setModel($this->model)
            ->setParameters([
                'modelId' => $this->modelId,
                'relationTables' => $this->relationTables,
                'columnsInclude' => $this->columnsInclude,
                'searchable' => $this->searchable,
                'sort' => $this->sorts,
                'paginate' => $this->paginate,
                'where' => [
                    'games.date' => $d,
                ],
                'search' => $this->search,
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.page.analysis',
            compact('dataTable')
        )->layout('layouts.' . $this->layout);
    }

    public function go(Game $game)
    {
        $this->showModalShow = true;
        $this->detail = $game;
    }
    public function addSort($field)
    {
        // dd($field);
        if (isset($this->sorts[$field])) {
            $this->sorts[$field] = $this->sorts[$field] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sorts = [];
            $this->sorts[$field] = '';
            $this->sorts[$field] = 'asc';
        }
        // dd($this->sorts);
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


    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
