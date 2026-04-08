<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class UserGroups extends Component
{
    public $user;
    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.admin.users.user-groups');
    }
    public function remove($levelToRemove)
    {
        // Decodifica os níveis de acesso
        $accessLevels = $this->user->jsonGroups;
        // Remove o nível de acesso específico
        $accessLevels = array_filter($accessLevels, function ($level) use ($levelToRemove) {
            return $level !== $levelToRemove;
        });
        // Atualiza os níveis de acesso do usuário
        $this->user->groups = array_values($accessLevels); // array_values para resetar as chaves do array
        // Salva as mudanças no banco de dados
        $this->user->save();
        // Atualiza a propriedade do componente
        $this->user = $this->user->fresh();
    }
}
