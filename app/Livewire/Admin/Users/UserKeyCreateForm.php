<?php

namespace App\Livewire\Admin\Users;

use App\Models\UserKey;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use phpseclib3\Crypt\RSA;
use Exception;
use Illuminate\Validation\ValidationException;

class UserKeyCreateForm extends Component
{
    public $rules;
    public $messages;
    public $user_key_created_at;
    public $state = [
        'key_password' => '',
        'key_password_confirmation' => '',
    ];

    public function generatePrivateKey()
    {
        // dd($this->state['key_password'], $this->state['key_password_confirmation']);
        // Valida a senha fornecida (mínimo 8 caracteres, 1 letra e 1 número)
        $this->rules = [
            'state.key_password' => 'required|min:8|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_+\-=\[\]{};:\'",.<>\/?]+/',
            'state.key_password_confirmation' => 'required|same:state.key_password',
        ];
        $this->messages = [
            'state.key_password.required' => 'Preenchimento obrigatório.',
            'state.key_password.min' => 'Deve conter no mínimo 8 caractéres.',
            'state.key_password.regex' => 'Deve conter pelo menos 1 letra, 1 número e 1 caracter especial',
            'state.key_password_confirmation.required' => 'Preenchimento obrigatório.',
            'state.key_password_confirmation.same' => 'Deve ser idêntico ao campo acima.',
        ];
        $this->validate();

        // Gera um novo par de chaves RSA
        $keyPair = RSA::createKey(2048);
        $privateKey = $keyPair->toString('PKCS8');
        $encryptedKey = $this->encryptWithPassword($privateKey, $this->state['key_password']);
        $publicKey = $keyPair->getPublicKey()->toString('PKCS8');

        // Cria a entrada no banco de dados para obter o ID da chave
        $userKey = UserKey::create([
            'user_id' => Auth::id(),
            'private_key_path' => "private/keys/",
            'public_key_path' => "private/keys/",
        ]);

        // Define os caminhos dos arquivos com ID do usuário e ID da chave
        $uuid = Str::uuid();
        $privateKeyPath = "private/keys/{$uuid}-{$userKey->id}.pem";
        $publicKeyPath = "private/keys/{$uuid}-{$userKey->id}.pem";

        // Certifique-se de que o diretório exista e valide sua criação
        if (!Storage::exists('private/keys') && !Storage::makeDirectory('private/keys')) {
            throw new Exception("Falha ao criar o diretório de chaves.");
        }

        // Salva as chaves no diretório de armazenamento
        Storage::put($privateKeyPath, $encryptedKey);
        Storage::put($publicKeyPath, $publicKey);

        // Atualiza o registro no banco com os caminhos das chaves
        $userKey->update([
            'private_key_path' => $privateKeyPath,
            'public_key_path' => $publicKeyPath,
        ]);

        // Limpa a senha do estado por segurança
        $this->state['key_password'] = '';
        $this->state['key_password_confirmation'] = '';

        $this->dispatch('saved');
    }

    private function encryptWithPassword($data, $password)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $password, 0, $iv);

        // Retorna os dados encriptados junto com o vetor de inicialização (IV)
        return base64_encode($encryptedData . '::' . $iv);
    }

    public function render()
    {
        $this->user_key_created_at = UserKey::where('user_id', Auth::id())->latest()->value('created_at');
        if ($this->user_key_created_at) {
            $this->user_key_created_at = Carbon::parse($this->user_key_created_at)->format('d/m/Y à\s H:i:s');
        }
        return view('profile.user-key-create-form');
    }

    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
