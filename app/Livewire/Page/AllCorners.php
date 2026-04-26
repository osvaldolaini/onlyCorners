<?php

namespace App\Livewire\Page;


use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanAllCorner;

use Livewire\WithPagination;

class AllCorners extends Component
{
    // Define o layout a ser usado
    protected $layout = 'page';

    use WithPagination;
    public $breadcrumb = 'Todos escanteios';
    public $modal = false;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $corners;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "Modules\Corner\App\Models\Corner"; //Model principal
    public $modelId = "corners.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['corners.id' => 'desc'];
    public $relationTables =  "teams,teams.id,corners.team_id | championships,championships.id,corners.championship_id";
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'corners.game_id,corners.date,corners.min,corners.favored_id,corners.half,corners.opponent_id,corners.team_id,corners.championship_id,championships.logo_path,championships.nick,teams.logo_path,teams.nick,corners.active as status';
    public $searchable = 'teams.nick,corners.date'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'corners.active';


    public function render(TableService $queryService)
    {
        $dataTable = $queryService
            ->setModel($this->model)
            ->setParameters([
                'modelId' => $this->modelId,
                'relationTables' => $this->relationTables,
                'columnsInclude' => $this->columnsInclude,
                'searchable' => $this->searchable,
                'sort' => $this->sorts,
                'paginate' => $this->paginate,
                'search' => $this->search,
                'customSearch' => $this->customSearch,
                'active' => $this->active,
            ])
            ->getData();
        return view(
            'livewire.page.all-corners',
            compact('dataTable')
        )->layout('layouts.' . $this->layout);
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
    public function get_data()
    {
        return Excel::download(
            new PlanAllCorner(),
            'planilha_todos_escanteios.xlsx'
        );
    }


    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
