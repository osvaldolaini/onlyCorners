<?php

namespace Modules\Team\App\Livewire\Admin;

use Modules\Team\App\Models\Team;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TeamEdit extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    public $rules;

    public $back = 'teams-list';
    public $route = 'teams-list';

    public $breadcrumb = 'Clube';
    //Fields
    public $id;
    public $title;
    public $nick;
    public $code;
    public $country;
    public $team;


    public $logo_path;

    use WithFileUploads;

    public $uploadimage;
    public $photo;

    public $newImg = '';

    public function mount(Team $team)
    {
        if ($team->getAttributes()) {
            $this->id           = $team->id;
            $this->title        = $team->title;
            $this->nick         = $team->nick;
            $this->country      = strtolower($team->country);

            $this->logo_path    = $team->logo_path;
            if ($this->logo_path) {
                $this->photo        = $team->id . '/' . $team->logo_path;
            }
        }
    }
    public function render()
    {
        return view('team::livewire.admin.team-edit')->layout('layouts.' . $this->layout);
    }

    public function save()
    {
        $id = $this->real_save();

        if ($id) {
            $team = team::find($id);
            if ($team->getAttributes()) {
                $this->team         = $team;
                $this->id           = $team->id;
                $this->title        = $team->title;
                $this->code         = $team->code;
                $this->logo_path    = $team->logo_path;
                if ($this->logo_path) {
                    $this->photo        = $team->id . '/' . $team->logo_path;
                }
            }
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'title'   => 'required',
            'nick'   => 'required',
            'country'   => 'required',
        ];
        $this->validate();
        team::updateOrCreate([
            'id'    => $this->id,
        ], [
            'title'     => $this->title,
            'nick'      => $this->nick,
            'country'   => $this->country,
        ]);

        $id = false;
        $msg = 'Registro editado com sucesso.';


        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    //UPLOAD

    public function updated($property)
    {
        if ($property === 'uploadimage') {
            $this->validate([
                'uploadimage' => ['nullable', 'mimes:jpg,jpeg,png'],
            ]);

            $directory = 'teams/' . $this->team->id;
            $fullPath = storage_path('app/' . $directory);

            // Apaga apenas a imagem anterior, se existir
            if ($this->team->logo_path) {
                Storage::delete($directory . '/' . $this->team->logo_path);
            }

            if ($this->uploadimage) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.jpg';

                // Criar diretório com permissões forçadas
                if (!file_exists($fullPath)) {
                    umask(0); // Remove restrições do sistema
                    mkdir($fullPath, 0755, true);
                }
                chmod($fullPath, 0755); // Garante a permissão correta

                // Salvar a nova imagem
                $this->uploadimage->storeAs($directory, $new_name, 'public');
                // $this->uploadimage->storeAs('logos-school', $new_name, 'public');

                // Atualizar o caminho da imagem no banco
                $this->team->logo_path = $new_name;
                $this->team->save();

                // Chamar a função logo
                $this->logo(
                    'teams/' . $this->team->id . '/' . $new_name,
                    $this->team->id,
                    $code
                );
            }
        }
    }


    public function excluirTemp()
    {
        $this->uploadimage = '';
    }
    public function excluirPhoto()
    {
        $this->team->logo_path = '';
        $this->team->save();
        if (Storage::directoryMissing('public/teams/' . $this->team->id)) {
            Storage::makeDirectory('public/teams/' . $this->team->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/teams/' . $this->team->id);
        $this->photo = $this->team->logo_path;
    }

    public static function logo($path, $id, $code)
    {
        // Corrige o caminho do arquivo original
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            throw new \Exception("Imagem não encontrada: " . $fullPath);
        }

        // Criar o gerenciador de imagem
        $manager = new ImageManager(new Driver());

        // Carregar a imagem
        $image = $manager->read($fullPath);

        // Caminho de destino
        $savePath = storage_path('app/public/teams/' . $id . '/');

        // Criar diretório se não existir
        if (!file_exists($savePath)) {
            umask(0022); // Garante permissões adequadas
            mkdir($savePath, 0755, true);
            chmod($savePath, 0755); // Ajusta a permissão corretamente
        }

        // Criar versões redimensionadas da imagem
        $image->scale(width: 200)
            ->toPng()
            ->save($savePath . $code . '_big.png');

        $image->scale(width: 30)
            ->toPng()
            ->save($savePath . $code . '_small.png');

        // Criar imagem para a lista
        $footer = $manager->read($fullPath);
        $footer->scale(width: 60)
            ->toPng()
            ->save($savePath . $code . '_list.png');
    }
}
