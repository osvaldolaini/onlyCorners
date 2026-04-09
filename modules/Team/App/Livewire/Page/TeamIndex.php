<?php

namespace Modules\Team\App\Livewire\Page;

use Livewire\Component;

class TeamIndex extends Component
{
    public function render()
    {
        return view('team::livewire.page.team-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Team',
                'meta_description' => 'Descrição detalhada da página Team.',
                'meta_keywords' => 'team, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}