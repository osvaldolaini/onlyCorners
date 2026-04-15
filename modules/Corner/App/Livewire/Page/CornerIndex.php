<?php

namespace Modules\Corner\App\Livewire\Page;

use Livewire\Component;

class CornerIndex extends Component
{
    public function render()
    {
        return view('corner::livewire.page.corner-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Corner',
                'meta_description' => 'Descrição detalhada da página Corner.',
                'meta_keywords' => 'corner, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}