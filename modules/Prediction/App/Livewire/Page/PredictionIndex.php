<?php

namespace Modules\Prediction\App\Livewire\Page;

use Livewire\Component;

class PredictionIndex extends Component
{
    public function render()
    {
        return view('prediction::livewire.page.prediction-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Prediction',
                'meta_description' => 'Descrição detalhada da página Prediction.',
                'meta_keywords' => 'prediction, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}