<?php

namespace App\Livewire;

use Livewire\Component;

class SelectSearch extends Component
{
    public $nick;
    public $label = null;
    public $model;
    public $placeholder = 'Digite para buscar...';
    public $selected = null;
    public $required = false;

    public $search = '';
    public $options = [];

    public function mount(
        $nick,
        $model,
        $label = null,
        $selected = null,
        $placeholder = null,
        $required = false
    ) {
        $this->nick        = $nick;
        $this->model       = $model;
        $this->label       = $label;
        $this->selected    = $selected;
        $this->placeholder = $placeholder ?? 'Digite para buscar...';
        $this->required    = $required;

        if ($this->selected) {
            $this->loadSelectedOption();
        }
    }

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->options = [];
            return;
        }

        $this->options = $this->model::where('nick', 'LIKE', "%{$this->search}%")
            ->limit(15)
            ->get()
            ->map(fn($item) => [
                'value' => $item->id,
                'text'  => $item->nick,
            ])
            ->toArray();
    }

    public function selectOption($value)
    {
        $this->selected = $value;
        $this->search = '';
        $this->options = [];

        // === DISPATCH PARA O COMPONENTE PAI ===
        $this->dispatch('select-search-selected', [
            'name'  => $this->nick,
            'value' => $value
        ]);
    }

    public function clear()
    {
        $this->selected = null;
        $this->search = '';
        $this->options = [];

        // === DISPATCH PARA O COMPONENTE PAI (quando remove) ===
        $this->dispatch('select-search-cleared', [
            'name' => $this->nick
        ]);
    }

    private function loadSelectedOption()
    {
        $option = $this->model::find($this->selected);
        if ($option) {
            $this->options = [[
                'value' => $option->id,
                'text'  => $option->nick,
            ]];
        }
    }

    public function render()
    {
        return view('livewire.select-search');
    }
}
