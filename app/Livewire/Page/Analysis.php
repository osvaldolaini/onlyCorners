<?php

namespace App\Livewire\Page;

use Livewire\Component;

use App\Services\LaiGuz\TableService;

use Livewire\WithPagination;
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


    public function render(TableService $queryService)
    {
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


    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
