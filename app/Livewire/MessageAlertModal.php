<?php

namespace App\Livewire;

use Livewire\Component;

class MessageAlertModal extends Component
{
    public $alertSession;
    protected $listeners =
    [
        'closeAlertModal',
        'openAlertModal',
    ];
    public function render()
    {
        return view('livewire.message-alert-modal');
    }
    //CLOSE MESSAGE
    public function closeAlertModal()
    {
        $this->alertSession = false;
    }
    //OPEN MESSAGE
    public function openAlertModal($status, $msg)
    {
        session()->flash($status, $msg);
        $this->alertSession = true;
    }
}
