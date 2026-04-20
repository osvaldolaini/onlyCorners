<?php

namespace App\Livewire\Admin\Page;

use App\Models\Admin\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Championship\App\Models\Championship;
use Modules\Prediction\App\Models\Prediction;
use Modules\Team\App\Models\Team;

class Panel extends Component
{
    public $config;
    public $teams;
    public $championships;
    public $chart;
    public $labels;
    public $wins;
    public $losses;
    // Define o layout a ser usado
    protected $layout = 'app';

    public function mount()
    {
        $this->teams = Team::where('active', 1)->get()->count();
        $this->championships = Championship::where('active', 1)->get()->count();
        $this->config = Settings::find(1);
        $this->chart = $this->chart();
    }
    public function render()
    {
        return view('livewire.admin.page.panel')->layout('layouts.' . $this->layout);
    }

    public function chart()
    {
        $months = [];
        $labels = [];
        $wins = [];
        $losses = [];

        // últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthKey = $date->format('Y-m');
            $months[] = $monthKey;

            $labels[] = $date->locale('pt-BR')->translatedFormat('M');
        }

        foreach ($months as $month) {

            $start = \Carbon\Carbon::parse($month)->startOfMonth();
            $end   = \Carbon\Carbon::parse($month)->endOfMonth();

            $winCount = Prediction::whereBetween('created_at', [$start, $end])
                ->where('status', 'won')
                ->count();

            $lossCount = Prediction::whereBetween('created_at', [$start, $end])
                ->where('status', 'lost')
                ->count();

            $wins[] = $winCount;
            $losses[] = $lossCount;
        }

        $this->labels = $labels;
        $this->wins = $wins;
        $this->losses = $losses;
    }
}
