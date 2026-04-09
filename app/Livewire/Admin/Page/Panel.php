<?php

namespace App\Livewire\Admin\Page;

use App\Models\Admin\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Team\App\Models\Team;

class Panel extends Component
{
    public $config;
    public $teams;
    // Define o layout a ser usado
    protected $layout = 'app';

    public function mount()
    {
        $this->teams = Team::where('active', 1)->get();
        $this->config = Settings::find(1);
    }
    public function render()
    {
        return view('livewire.admin.page.panel')->layout('layouts.' . $this->layout);
    }
}
