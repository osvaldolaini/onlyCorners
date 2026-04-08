<?php

namespace App\Livewire\Admin\Page;

use Livewire\Component;

class NavBar extends Component
{
    public function render()
    {
        return view('livewire.admin.page.nav-bar');
    }

    public function openModalSearch()
    {
        $this->emit('openModalSearch');
    }
}
