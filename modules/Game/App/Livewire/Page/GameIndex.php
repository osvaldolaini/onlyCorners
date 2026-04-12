<?php

namespace Modules\Game\App\Livewire\Page;

use Livewire\Component;

class GameIndex extends Component
{
    public function render()
    {
        return view('game::livewire.page.game-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Game',
                'meta_description' => 'Descrição detalhada da página Game.',
                'meta_keywords' => 'game, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}