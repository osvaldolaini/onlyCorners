<?php

namespace Modules\Prediction\App\Livewire\Admin;

use Livewire\Component;
use Modules\Prediction\App\Models\Prediction;

class PredictionHistory extends Component
{
    protected $layout = 'app';

    public $breadcrumb = 'Histórico de previsões';
    public $cards = [];

    public $showModalShow = false;
    public $detail;
    public function render()
    {
        $this->cards = Prediction::where('status', '!=', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('prediction::livewire.admin.prediction-history')
            ->layout('layouts.' . $this->layout);
    }
    public function showModal($id)
    {
        $this->showModalShow = true;
        // dd();
        $this->detail = Prediction::find($id);
        // dd($this->detail, $id);
    }
}
