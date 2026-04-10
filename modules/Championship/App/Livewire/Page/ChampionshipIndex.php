<?php

namespace Modules\Championship\App\Livewire\Page;

use Livewire\Component;

class ChampionshipIndex extends Component
{
    public function render()
    {
        return view('championship::livewire.page.championship-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Championship',
                'meta_description' => 'Descrição detalhada da página Championship.',
                'meta_keywords' => 'championship, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}