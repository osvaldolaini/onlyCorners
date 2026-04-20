<?php

namespace Modules\Corner\App\Livewire\Admin;

use Livewire\Component;

use Illuminate\Support\Facades\Http;

class CornerEdit extends Component
{

    public function render()
    {

        $response = Http::withHeaders([
            'x-apisports-key' => '180c0b249bb80893f6bd007ce8f0473f',
        ])->get('https://v3.football.api-sports.io/leagues');

        if ($response->successful()) {
            $data = $response->json();
            return $data;
        }

        return $response->status();
        return view('corner::livewire.admin.corner-edit');
    }
}
