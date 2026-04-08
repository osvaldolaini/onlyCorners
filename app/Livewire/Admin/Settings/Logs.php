<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class Logs extends Component
{
    public function mount()
    {
        $this->redirect('/log-viewer');
    }
    public function render()
    {
        return view('livewire.admin.settings.logs');
    }
}
