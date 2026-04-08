<?php

namespace App\Livewire\Admin\Page;

use App\Models\Discipline\FactObserved;
use Livewire\Component;
use Livewire\Attributes\On;

class SideBar extends Component
{
    public $fo;
    #[On('update')]
    public function render()
    {

        return view('livewire.admin.page.side-bar');
    }
}
