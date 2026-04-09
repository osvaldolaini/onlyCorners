<?php

namespace Modules\Team\App\Livewire\Admin;


use Modules\Team\App\Models\Team;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;


use Illuminate\Support\Str;


class TeamForm extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    public $rules;

    public $back = 'teams-list';
    public $route = 'teams-list';

    public $breadcrumb = 'Novo clube';
    //Fields
    public $id;
    public $title;
    public $nick;
    public $country;

    public $newImg = '';

    public function render()
    {
        return view('team::livewire.admin.team-form')->layout('layouts.' . $this->layout);
    }

    public function save()
    {
        $id = $this->real_save();
        redirect()->route('team-edit', $id)->with('success', 'Registro criado com sucesso.');
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route('teams-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'title'     => 'required|unique:teams',
            'country'   => 'required',
            'nick'      => 'required',
        ];
        $this->validate();

        $teams = Team::create([
            'active'    => 1,
            'title'     => $this->title,
            'nick'      => $this->nick,
            'country'   => $this->country,
            'code'      => Str::uuid(),
        ]);
        $id = $teams->id;
        $msg = 'Registro criado com sucesso.';


        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
