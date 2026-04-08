<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserAccesses extends Component
{
    public $inputAccess = array();
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
            $this->inputAccess = $this->user->jsonAccesses;
        }
    }

    #[On('updateCheckbox')]
    public function updateCheckbox($checkboxs)
    {
        $this->checkboxs = $checkboxs;
        $index = array_search('all', $this->checkboxs);
        unset($this->checkboxs[$index]);
        // dd($this->checkboxs);
    }
    #[On('update')]
    public function render()
    {
        return view('livewire.admin.users.user-accesses');
    }

    public function changeAccess($page)
    {
        if ($page == 'all') {
            // Lógica se o ALL for clicado
            if (in_array($page, $this->inputAccess)) {
                $this->inputAccess = [];
            } else {
                $this->inputAccess = ['all'];
            }
            // dd($this->inputAccess);
        } else {
            if (in_array('all', $this->inputAccess)) {
                $index = array_search('all', $this->checkboxs);
                unset($this->checkboxs[$index]);
                $this->inputAccess = $this->checkboxs;
            }

            if (in_array($page, $this->inputAccess)) {
                // Remove o acesso se ele já estiver presente
                $this->inputAccess = array_filter($this->inputAccess, function ($access) use ($page) {
                    return $access !== $page;
                });
            } else {
                // Adiciona o acesso se ele não estiver presente
                $this->inputAccess[] = $page;
            }
            // dd($this->inputAccess);
        }

        if (count($this->inputAccess) == count($this->checkboxs)) {
            $this->inputAccess = ['all'];
        }

        // Atualiza os acessos do usuário no banco de dados
        $this->user->accesses = array_values($this->inputAccess);
        $this->user->save();
        $this->dispatch('update');
    }
}
