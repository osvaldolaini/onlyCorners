<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class SeeExcluded extends Component
{
    public $see_excluded;

    #[On('see_excluded')]
    public function render()
    {
        $this->see_excluded = Auth::user()->see_excluded;
        return view('livewire.admin.users.see-excluded');
    }

    public function buttonSee()
    {
        $this->see_excluded = !Auth::user()->see_excluded;
        $user = User::find(Auth::user()->id);
        $user->see_excluded = $this->see_excluded;
        $user->save();
        $this->dispatch('see_excluded');
    }
}
