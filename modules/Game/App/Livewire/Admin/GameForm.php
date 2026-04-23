<?php

namespace Modules\Game\App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

use Illuminate\Support\Str;
use Modules\Game\App\Models\Game;

class GameForm extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    public $rules;

    public $back = 'games-list';
    public $route = 'games-list';

    public $breadcrumb = 'Novo jogo';
    //Fields
    public $id;
    public $team_id;
    public $opponent_id;
    public $championship_id;
    public $date;
    public $hour;

    public $newImg = '';

    public function render()
    {
        return view('game::livewire.admin.game-form')->layout('layouts.' . $this->layout);
    }

    public function save()
    {
        $id = $this->real_save();
        redirect()->route('game-edit', $id)->with('success', 'Registro criado com sucesso.');
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route('games-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {

        $this->rules = [
            'team_id'           => 'required',
            'date'              => 'required',
            'hour'              => 'required',
            'opponent_id'       => 'required',
            'championship_id'   => 'required',
            'opponent_id'       => 'required',
        ];
        $this->validate();

        $games = Game::create([
            'active'            => 1,
            'date'              => $this->date,
            'hour'              => $this->hour,
            'team_id'           => $this->team_id,
            'opponent_id'       => $this->opponent_id,
            'championship_id'   => $this->championship_id,
            'code'              => Str::uuid(),
        ]);
        $id = $games->id;
        $msg = 'Registro criado com sucesso.';


        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    #[On('select-search-selected')]
    public function handleSelectSearch($data)
    {
        $this->{$data['name']} = $data['value'];   // Ex: $this->team_id = $value;

    }

    #[On('select-search-cleared')]
    public function handleSelectCleared($data)
    {
        $this->{$data['name']} = null;   // Limpa a propriedade no componente pai
    }
}
