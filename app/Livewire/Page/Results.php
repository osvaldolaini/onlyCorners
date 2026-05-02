<?php

namespace App\Livewire\Page;

use Livewire\Component;

use Modules\Prediction\App\Models\Prediction;

class Results extends Component
{
    // Define o layout a ser usado
    protected $layout = 'page';
    public $cards = [];
    public $breadcrumb = 'Resultados';

    public $showModalShow = false;
    public $detail;

    public $config;
    public $teams;
    public $championships;
    public $corners;

    public $labelsMonth = [];
    public $winsMonth = [];
    public $lossesMonth = [];

    public $labels = [];
    public $wins = [];
    public $losses = [];

    public function render()
    {
        $this->cards = Prediction::where('status', '!=', 'pending')
            ->orderByDesc('created_at')
            ->get();
        $this->chart();
        $this->chartByType();
        return view('livewire.page.results')
            ->layout('layouts.' . $this->layout);
    }

    public function showModal($id)
    {
        $this->showModalShow = true;
        // dd();
        $this->detail = Prediction::find($id);
        // dd($this->detail, $id);
    }
    public function chartByType()
    {
        $types = ['safe', 'medium', 'aggressive'];

        $labels = [];
        $wins = [];
        $losses = [];

        foreach ($types as $type) {

            $labels[] = ucfirst($type);

            $wins[] = Prediction::where('type', $type)
                ->where('status', 'won')
                ->count();

            $losses[] = Prediction::where('type', $type)
                ->where('status', 'lost')
                ->count();
        }

        $this->labels = $labels;
        $this->wins = $wins;
        $this->losses = $losses;
    }

    public function chart()
    {
        $months = [];
        $labels = [];
        $wins = [];
        $losses = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthKey = $date->format('Y-m');
            $months[] = $monthKey;

            $labels[] = $date->locale('pt-BR')->translatedFormat('M');
        }

        foreach ($months as $month) {

            $start = \Carbon\Carbon::parse($month)->startOfMonth();
            $end   = \Carbon\Carbon::parse($month)->endOfMonth();

            $wins[] = Prediction::whereBetween('created_at', [$start, $end])
                ->where('status', 'won')
                ->count();

            $losses[] = Prediction::whereBetween('created_at', [$start, $end])
                ->where('status', 'lost')
                ->count();
        }

        $this->labelsMonth = $labels;
        $this->winsMonth = $wins;
        $this->lossesMonth = $losses;
    }
}
