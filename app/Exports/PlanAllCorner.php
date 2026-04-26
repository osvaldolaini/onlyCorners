<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;
use Modules\Corner\App\Models\Corner;

class PlanAllCorner implements FromView, WithProperties
{

    public function __construct()
    {
        // 
    }

    public function view(): View
    {
        return view('livewire.page.plan-all-corners', [
            'title'           => 'Todos escanteios',
            'data'            => Corner::all(),
        ]);
    }

    public function properties(): array
    {
        return [
            'creator'        => Auth::user()->name,
        ];
    }
}
