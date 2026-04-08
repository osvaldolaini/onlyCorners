<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class UserUploadImage extends Component
{
    use WithFileUploads;

    public $uploadimage;
    public $user;
    public $photo;
    public $rules;
    public $valid = false;

    public function mount($id)
    {
        if ($id) {
            $this->user = User::find($id);
            $this->photo = '';
        }
    }
    public function render()
    {
        return view('livewire.admin.users.user-upload-image');
    }
    public function changePhoto()
    {
        $this->dispatch('submitForm');
    }
    public function updated($property)
    // public function uploadPhoto()
    {
        if ($property === 'photo') {
            if ($this->user) {
                $this->user->updateProfilePhoto($this->photo);
                $this->openAlert('success', 'Imagem alterada com sucesso.');
            } else {
                $this->openAlert('error', 'Usuário não encontrado.');
            }
        }
    }
    public function deleteProfilePhoto()
    {
        if ($this->user && $this->user->profile_photo_path) {
            $this->user->deleteProfilePhoto();
            $this->user->save();
            $this->openAlert('success', 'Imagem excluida com sucesso.');
        } else {
            $this->openAlert('error', 'Usuário não encontrado com sucesso.');
        }
    }

    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
