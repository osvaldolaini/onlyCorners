<?php

namespace Modules\Corner\App\Livewire\Admin;

use Livewire\Component;
use Modules\Corner\App\Models\Corner;
use Modules\Game\App\Models\Game;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Exception;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CornerList extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    public $breadcrumb = 'Escanteios do jogo:';
    public $game;
    public $corners;
    public $half;
    public $min;
    public $favored_id;

    public function mount(Game $game)
    {
        $this->game = $game;
        $this->corners = $this->game->corners()
            ->with(['team', 'opponent'])   // carrega os relacionamentos necessários
            ->orderBy('min', 'desc')
            ->get();
        $this->half = $game->half;
        $this->favored_id = $game->favored_id;
    }



    public function render()
    {
        return view('corner::livewire.admin.corner-list')->layout('layouts.' . $this->layout);
        $this->corners = $this->game->corners()
            ->with(['team', 'opponent'])   // carrega os relacionamentos necessários
            ->orderBy('min', 'desc')
            ->get();
    }

    public function cleanCorners()
    {
        if ($this->corners) {
            foreach ($this->corners as $corner) {
                $corner->delete();
            }
        }

        $this->loadCorners();
    }


    public function getSofaScore()
    {
        $pythonExecutable = "C:\\laragon\\bin\\python\\python-3.10\\python.exe"; // ou caminho absoluto se necessário
        $script = base_path("python\get_only_corner.py");

        $command = [
            $pythonExecutable,
            $script,
        ];

        // Criar uma nova instância de Process
        $process = new Process($command);

        $process->setTimeout(120);        // ou 180 segundos
        // $process->setTimeout(null);    // sem timeout (cuidado em produção)

        $process->setInput(json_encode($this->game->id));


        $process->run();

        if (!$process->isSuccessful()) {
            dd($process->getErrorOutput());
        }

        $output = $process->getOutput();

        $decoded = json_decode($output, true);
        // dd($decoded);
        if ($decoded['success']) {
            //deleta os antigos
            $this->cleanCorners();
            foreach ($decoded['results'] as $corners) {

                // =====================
                // 🟢 CASA - 1º TEMPO
                // =====================
                if ($corners['home_first_half'] > 0) {
                    for ($i = 0; $i < $corners['home_first_half']; $i++) {
                        Corner::create([
                            'active'            => 1,
                            'date'              => $this->game->date,
                            'hour'              => $this->game->hour,
                            'game_id'           => $this->game->id,
                            'team_id'           => $this->game->team_id,
                            'opponent_id'       => $this->game->opponent_id,
                            'championship_id'   => $this->game->championship_id,
                            'favored_id'        => $this->game->team_id,
                            'half'              => 'first',
                            'code'              => Str::uuid(),
                        ]);
                    }
                }

                // =====================
                // 🔵 CASA - 2º TEMPO
                // =====================
                if ($corners['home_second_half'] > 0) {
                    for ($i = 0; $i < $corners['home_second_half']; $i++) {
                        Corner::create([
                            'active'            => 1,
                            'date'              => $this->game->date,
                            'hour'              => $this->game->hour,
                            'game_id'           => $this->game->id,
                            'team_id'           => $this->game->team_id,
                            'opponent_id'       => $this->game->opponent_id,
                            'championship_id'   => $this->game->championship_id,
                            'favored_id'        => $this->game->team_id,
                            'half'              => 'second',
                            'code'              => Str::uuid(),
                        ]);
                    }
                }

                // =====================
                // 🔴 VISITANTE - 1º TEMPO
                // =====================
                if ($corners['away_first_half'] > 0) {
                    for ($i = 0; $i < $corners['away_first_half']; $i++) {
                        Corner::create([
                            'active'            => 1,
                            'date'              => $this->game->date,
                            'hour'              => $this->game->hour,
                            'game_id'           => $this->game->id,
                            'team_id'           => $this->game->team_id,
                            'opponent_id'       => $this->game->opponent_id,
                            'championship_id'   => $this->game->championship_id,
                            'favored_id'        => $this->game->opponent_id,
                            'half'              => 'first',
                            'code'              => Str::uuid(),
                        ]);
                    }
                }

                // =====================
                // 🟡 VISITANTE - 2º TEMPO
                // =====================
                if ($corners['away_second_half'] > 0) {
                    for ($i = 0; $i < $corners['away_second_half']; $i++) {
                        Corner::create([
                            'active'            => 1,
                            'date'              => $this->game->date,
                            'hour'              => $this->game->hour,
                            'game_id'           => $this->game->id,
                            'team_id'           => $this->game->team_id,
                            'opponent_id'       => $this->game->opponent_id,
                            'championship_id'   => $this->game->championship_id,
                            'favored_id'        => $this->game->opponent_id,
                            'half'              => 'second',
                            'code'              => Str::uuid(),
                        ]);
                    }
                }
            }
        } else {
            $this->openAlert('error', 'Nenhum jogo encontrado.');
            // dd('Sem jogos');
        }

        $this->openAlert('success', 'Registros inseridos/atualizados com sucesso.');

        $this->loadCorners();
    }
    public function generateCardsFromPython(array $gamesMarkets): array
    {

        $pythonExecutable = "C:\\laragon\\bin\\python\\python-3.10\\python.exe"; // ou caminho absoluto se necessário
        $script = base_path("python\bet_engine.py");


        $command = [
            $pythonExecutable,
            $script,
        ];

        // Criar uma nova instância de Process
        $process = new Process($command);

        $process->setTimeout(120);        // ou 180 segundos
        // $process->setTimeout(null);    // sem timeout (cuidado em produção)

        $process->setInput(json_encode($gamesMarkets));

        $process->run();

        if (!$process->isSuccessful()) {
            dd($process->getErrorOutput());
        }

        $output = $process->getOutput();

        $decoded = json_decode($output, true);
        // $this->normalizePythonResponse($decoded);
        return $this->normalizePythonResponse($decoded) ?? [];
    }


    public function incrementMinute(Corner $corner)
    {
        $currentMinutes = $this->getMinutesFromTime($corner->min ?? '00:00');

        $newMinutes = $currentMinutes + 1;

        // Limite opcional (ex: máximo 120 minutos)
        if ($newMinutes > 120) {
            $newMinutes = 120;
        }

        $corner->min = $this->minutesToTime($newMinutes);
        $corner->save();

        $this->loadCorners();
    }

    public function decrementMinute(Corner $corner)
    {
        $currentMinutes = $this->getMinutesFromTime($corner->min ?? '00:00');

        $newMinutes = $currentMinutes - 1;

        if ($newMinutes < 0) {
            $newMinutes = 0;
        }

        $corner->min = $this->minutesToTime($newMinutes);
        $corner->save();

        $this->loadCorners();
    }

    public function addRow()
    {
        Corner::create([
            'active'            => 1,
            'date'              => $this->game->date,
            'hour'              => $this->game->hour,
            'game_id'           => $this->game->id,
            'team_id'           => $this->game->team_id,
            'opponent_id'       => $this->game->opponent_id,
            'championship_id'   => $this->game->championship_id,
            'code'              => Str::uuid(),
        ]);
        $this->loadCorners();
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    private function loadCorners()
    {
        $this->corners = $this->game->corners()
            ->with(['team', 'opponent'])   // carrega os relacionamentos necessários
            ->orderBy('min', 'desc')
            ->get();

        $this->openAlert('success', 'Editado com sucesso');
    }

    public function removeRow($id)
    {
        $corners = Corner::find($id);
        $corners->delete();
        $this->loadCorners();
    }
    public function updateCornerTeam(Corner $corner, $team)
    {
        $corner->favored_id = $team;

        $corner->save();
        $this->loadCorners();
    }

    public function updateCornerHalf(Corner $corner, $val)
    {
        $corner->half = $val;

        $corner->save();
        $this->loadCorners();
        // $this->openAlert('success', 'Editado com sucesso');
        // dd($val, $corner);
    }
    public function updated($property)
    {
        if ($property === 'contact') {
            Corner::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'contact' => $this->contact,
            ]);
        }
        if ($property === 'parent') {
            Corner::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'parent' => $this->parent,
            ]);
        }
        if ($property === 'type') {
            Corner::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'type' => $this->type,
            ]);
        }
    }
    /**
     * Converte 'HH:MM' ou 'HH:MM:SS' para total de minutos (inteiro)
     */
    private function getMinutesFromTime($timeString)
    {
        if (empty($timeString)) {
            return 0;
        }

        // Garante que é string
        $timeString = (string) $timeString;

        try {
            $carbon = Carbon::createFromFormat('H:i:s', $timeString);
        } catch (\Exception $e) {
            try {
                $carbon = Carbon::createFromFormat('H:i', $timeString);
            } catch (\Exception $e2) {
                return 0; // fallback
            }
        }

        return ($carbon->hour * 60) + $carbon->minute;
    }

    /**
     * Converte minutos inteiros para formato time 'HH:MM' ou 'HH:MM:SS'
     */
    private function minutesToTime($totalMinutes, $withSeconds = false)
    {
        $hours = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        if ($withSeconds) {
            return sprintf('%02d:%02d:00', $hours, $minutes);
        }

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
