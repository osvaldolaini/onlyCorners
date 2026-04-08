<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dark extends Component
{
    public $darkMode;
    public function render()
    {
        return view('livewire.admin.users.dark');
    }
    public function mount()
    {
        $this->darkMode = Auth::user()->dark;
    }

    public function toggleDarkMode()
    {

        $user = Auth::user();
        $user->dark = !$user->dark;
        $user->save();

        $this->darkMode = $user->dark;
        $this->dispatch('darkModeToggled', $this->darkMode);
    }
}
