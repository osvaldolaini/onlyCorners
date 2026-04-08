<?php

namespace App\Livewire\Admin\Users;

use App\Models\Settings\Companies;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserCompanies extends Component
{
    public $inputCompanies = array();
    public $user;
    public $breadcrumb_title;
    public $dashboard;
    public $pages;
    public $companies;
    public $checkboxs = array();
    public $all = false;

    public function mount($user)
    {
        if ($user) {
            $this->user = $user;
            $this->inputCompanies = $this->user->json_companies;
        }
        $this->companies = Companies::where('active', 1)->get();
    }

    #[On('updateCheckboxCompanies')]
    public function updateCheckboxCompanies($val)
    {
        $this->checkboxs = $val;
        $index = array_search('all', $this->checkboxs);
        unset($this->checkboxs[$index]);
        // dd($this->checkboxs);
    }
    #[On('update')]
    public function render()
    {
        return view('livewire.admin.users.user-companies');
    }

    public function changeCompanies($page)
    {

        if ($page == 'all') {
            // Lógica se o ALL for clicado
            if (in_array($page, $this->inputCompanies)) {
                $this->inputCompanies = [];
            } else {
                $this->inputCompanies = ['all'];
            }
        } else {
            if (in_array('all', $this->inputCompanies)) {
                $index = array_search('all', $this->checkboxs);
                unset($this->checkboxs[$index]);
                $this->inputCompanies = $this->checkboxs;
            }

            if (in_array($page, $this->inputCompanies)) {
                // Remove o acesso se ele já estiver presente
                $this->inputCompanies = array_filter($this->inputCompanies, function ($company) use ($page) {
                    return $company !== $page;
                });
            } else {
                // Adiciona o acesso se ele não estiver presente
                $this->inputCompanies[] = $page;
            }
            // dd($this->inputCompanies;
        }

        if (count($this->inputCompanies) == count($this->checkboxs)) {
            $this->inputCompanies = ['all'];
        }
        // dd(array_values($this->inputCompanies));
        // Atualiza os acessos do usuário no banco de dados
        $this->user->companies = array_values($this->inputCompanies);
        $this->user->save();
        $this->dispatch('update');
    }
}
