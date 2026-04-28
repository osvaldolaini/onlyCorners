<?php

namespace Modules\Game\App\Livewire\Admin;

use App\Services\LaiGuz\TableService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Game\App\Models\Game;

use Illuminate\Support\Str;

use Exception;
use Modules\Championship\App\Models\Championship;
use Modules\Team\App\Models\Team;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GameList extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    use WithPagination;
    public $breadcrumb = 'Jogos';
    public $modal = false;
    public $showJetModal = false;
    public $showModalForm = false;

    public $rules;
    public $detail;
    public $games;
    public $id;

    //Dados da tabela
    protected $queryService;
    public $model = "Modules\Game\App\Models\Game"; //Model principal
    public $modelId = "games.id"; //Ex: 'table.id' or 'id'
    public $search;
    public $sorts = ['games.date' => 'desc'];
    public $relationTables =  "teams,teams.id,games.team_id | championships,championships.id,games.championship_id";
    public $customSearch;  //Colunas personalizadas, customizar no model
    public $columnsInclude = 'games.date,games.hour,games.opponent_id,games.team_id,games.championship_id,championships.logo_path,championships.nick,teams.logo_path,teams.nick,games.active as status';
    public $searchable = 'teams.nick,nick,games.date,games.hour,'; //Colunas pesquisadas no banco de dados

    public $paginate = 15; //Qtd de registros por página
    public $active = 'games.active';

    public $tornament_id = 325;
    public $tot = 0;
    public $tournaments;

    public function getSofaScore()
    {

        $pythonExecutable = "C:\\laragon\\bin\\python\\python-3.10\\python.exe"; // ou caminho absoluto se necessário
        $script = base_path("python\get_only_games.py");


        $command = [
            $pythonExecutable,
            $script,
        ];

        // Criar uma nova instância de Process
        $process = new Process($command);

        $process->setTimeout(120);        // ou 180 segundos
        // $process->setTimeout(null);    // sem timeout (cuidado em produção)

        $process->setInput($this->tornament_id);

        $process->run();

        if (!$process->isSuccessful()) {
            dd($process->getErrorOutput());
        }

        $output = $process->getOutput();

        $decoded = json_decode($output, true);
        // dd($decoded);
        if ($decoded['success']) {
            foreach ($decoded['results'] as $game) {
                $home_team_id = Team::where('sofascore_id', $game['home_team_id'])->first()->id;
                $away_team_id = Team::where('sofascore_id', $game['away_team_id'])->first()->id;
                if ($game['date'] > date('Y-m-d')) {
                    $game = Game::updateOrCreate([
                        'id'    => $game['event_id'],
                    ], [
                        'active'            => 1,
                        'date'              =>  $game['date'],
                        'hour'              =>  $game['hour'],
                        'team_id'           => $home_team_id,
                        'opponent_id'       => $away_team_id,
                        'championship_id'   => $this->tornament_id,
                        'code'              => Str::uuid(),
                    ]);
                }

                $this->tot += 1;
                // dd($game);
            }

            $this->openAlert('success', 'Registros inseridos/atualizados com sucesso.');
        } else {
            $this->openAlert('error', 'Nenhum jogo encontrado.');
            // dd('Sem jogos');
        }
    }
    public function mount()
    {
        $this->tournaments = Championship::where('active', 1)->get();
    }

    #[On('see_excluded')]
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
            'game::livewire.admin.game-list',
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
    //CREATE
    public function showCreate()
    {
        if ($this->modal) {
            $this->showModalForm = true;
            $this->games = '';
        } else {
            redirect()->route('game-create');
        }
    }

    //Update
    public function showUpdate($id)
    {

        if ($this->modal) {
            $this->showModalForm = true;
            $this->games = Game::find($id);
        } else {
            redirect()->route('game-edit', $id);
        }
    }

    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = '';
        }
    }
    public function delete($id)
    {
        $data = Game::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = Game::where('id', $id)->first();
        if ($data->active == 1) {
            $data->active = 0;
            $data->save();
        } else {
            $data->active = 1;
            $data->save();
        }
        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
