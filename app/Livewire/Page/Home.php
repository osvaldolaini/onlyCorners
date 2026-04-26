<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Modules\Prediction\App\Models\Prediction;

class Home extends Component
{
    // Define o layout a ser usado
    protected $layout = 'page';
    public $bets = [];
    public $risks = ['safe', 'medium', 'aggressive']; // TODOS ativos por padrão
    public $showModalShow = false;
    public $detail;

    public function showModal($id)
    {
        $this->showModalShow = true;
        // dd();
        $this->detail = Prediction::find($id);
        // dd($this->detail, $id);
    }

    public function mount()
    {
        $this->loadBets();
    }
    public function go($id)
    {
        redirect()->route('detail', $id);
    }

    public function toggleRisk($risk)
    {
        if (in_array($risk, $this->risks)) {
            // remove
            $this->risks = array_values(array_diff($this->risks, [$risk]));
        } else {
            // adiciona
            $this->risks[] = $risk;
        }

        $this->loadBets();
    }

    public function loadBets()
    {
        $query = Prediction::where('status', 'pending')
            ->where('expired', '>', now())
            ->orderByDesc('created_at');

        if (!empty($this->risks)) {
            $query->whereIn('type', $this->risks);
        }

        $this->bets = $query->get();
    }
    public function render()
    {
        return view('livewire.page.home')->layout('layouts.' . $this->layout);
    }
}
