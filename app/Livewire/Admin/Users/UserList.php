<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserGroups as EnumsUserGroups;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    public $paginate;
    public $showJetModal = false;
    public $showModalView = false;
    public $alertSession = false;
    public $rules;
    public $detail;

    public $id;
    public $registerId;

    protected $listeners =
    [
        'showModalRead',
        'showModalDelete'
    ];

    public function render()
    {
        $currentUser = Auth::user();
        // if ) {
        //     # code...
        // }
        // $users = User::all()->filter(function ($user) use ($currentUser) {
        //     return $currentUser->hasCommonAccessWith($user);
        // });
        $users = User::where('active', 1)->get();
        return view('livewire.admin.users.user-list', [
            'users' => $users,
        ]);
    }

    //CREATE
    public function showModal($id = false)
    {
        if ($id) {
            redirect()->route('user-edit', $id);
        } else {
            redirect()->route('user-create');
        }
    }

    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->registerId = $id;
        } else {
            $this->registerId = '';
        }
    }
    public function delete($id)
    {
        $data = User::find($id);
        $data->delete();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }

    //OPEN MESSAGE
    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
    #END FUNCTIONS BUTTONS AND MESSAGE
}
