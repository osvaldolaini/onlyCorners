<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserCrud extends Component
{
    public $inputActivities = array();
    public $user;
    public $breadcrumb_title;
    public $dashboard;
    public $pages;
    public $checkboxs = array();
    public $all = false;

    public function mount($user)
    {
        if ($user) {
            $this->user = $user;
            $this->inputActivities = $this->user->jsonActivities;
            // dd($this->inputActivities, $user);
        }
    }
    #[On('update')]
    public function render()
    {
        return view('livewire.admin.users.user-crud');
    }

    public function changeAccess($page)
    {
        if (in_array('all', $this->inputActivities)) {
            $index = array_search('all', $this->checkboxs);
            unset($this->checkboxs[$index]);
            $this->inputActivities = $this->checkboxs;
        }

        if (in_array($page, $this->inputActivities)) {
            // Remove o acesso se ele já estiver presente
            $this->inputActivities = array_filter($this->inputActivities, function ($access) use ($page) {
                return $access !== $page;
            });
        } else {
            // Adiciona o acesso se ele não estiver presente
            $this->inputActivities[] = $page;
        }
        // dd($this->inputActivities);
        // Atualiza os acessos do usuário no banco de dados
        $this->user->activities = array_values($this->inputActivities);
        $this->user->save();
        $this->dispatch('update');
    }
}
