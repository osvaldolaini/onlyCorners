<?php

namespace Modules\Championship\App\Livewire\Admin;

use Modules\Championship\App\Models\Championship;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;


use Illuminate\Support\Str;

class ChampionshipForm extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    public $rules;

    public $back = 'championships-list';
    public $route = 'championships-list';

    public $breadcrumb = 'Novo campeonato';
    //Fields
    public $id;
    public $title;
    public $nick;
    public $type;

    public $newImg = '';

    public function render()
    {
        return view('championship::livewire.admin.championship-form')->layout('layouts.' . $this->layout);
    }

    public function save()
    {
        $id = $this->real_save();
        redirect()->route('championship-edit', $id)->with('success', 'Registro criado com sucesso.');
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route('championships-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'title'     => 'required|unique:championships',
            'type'      => 'required',
            'nick'      => 'required',
        ];
        $this->validate();

        $championships = Championship::create([
            'active'    => 1,
            'title'     => $this->title,
            'nick'      => $this->nick,
            'type'   => $this->type,
            'code'      => Str::uuid(),
        ]);
        $id = $championships->id;
        $msg = 'Registro criado com sucesso.';


        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
