<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Panel extends Component
{
    public $panel;
    public function render()
    {
        return view('livewire.admin.users.panel');
    }
    public function togglePanel($status)
    {
        if (in_array($status, json_decode(auth()->user()->groups))) {
            $user = Auth::user();
            $user->panel = $status;
            $user->save();
        }
        return redirect(auth()->user()->getRedirectRoute());
        // $this->dispatch('panelToggled', $this->panel);
    }
}
