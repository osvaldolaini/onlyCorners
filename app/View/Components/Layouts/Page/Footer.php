<?php

namespace App\View\Components\Layouts\Page;

use App\Models\Admin\Settings;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $contact;
    public $social;

    public function __construct()
    {
        $setting = Settings::first();

        $this->contact = (object) [
            'phone'  => $setting->phone  ?? '(00) 0000-0000',
            'email'  => $setting->email  ?? 'contato@empresa.com',
            'address' => $setting->address ?? 'Endereço não informado',
        ];

        $this->social = (object) [
            'facebook' => $setting->facebook ?? '#',
            'twitter'  => $setting->twitter ?? '#',
            'instagram' => $setting->instagram ?? '#',
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.page.footer');
    }
}
