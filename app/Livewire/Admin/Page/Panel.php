<?php

namespace App\Livewire\Admin\Page;

use App\Models\Admin\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Championship\App\Models\Championship;
use Modules\Team\App\Models\Team;

class Panel extends Component
{
    public $config;
    public $teams;
    public $championships;
    // Define o layout a ser usado
    protected $layout = 'app';

    public function mount()
    {
        $this->teams = Team::where('active', 1)->get()->count();
        $this->championships = Championship::where('active', 1)->get()->count();
        $this->config = Settings::find(1);
    }
    public function render()
    {
        return view('livewire.admin.page.panel')->layout('layouts.' . $this->layout);
    }
}
