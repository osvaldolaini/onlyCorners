<?php

namespace App\View\Components\Layouts\Page;

use App\Models\Admin\Settings;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $contact;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Exemplo: busca o primeiro registro da tabela de configurações
        $settings = Settings::first();
        view()->share('settings', $settings);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.page.header');
    }
}
