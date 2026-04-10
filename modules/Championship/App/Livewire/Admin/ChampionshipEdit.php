<?php

namespace Modules\Championship\App\Livewire\Admin;


use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Modules\Championship\App\Models\Championship;

class ChampionshipEdit extends Component
{

    // Define o layout a ser usado
    protected $layout = 'app';

    public $rules;

    public $back = 'championships-list';
    public $route = 'championships';

    public $breadcrumb = 'Campeonato';
    //Fields
    public $id;
    public $title;
    public $nick;
    public $code;
    public $type;
    public $championship;


    public $logo_path;

    use WithFileUploads;

    public $uploadimage;
    public $photo;

    public $newImg = '';

    public function mount(Championship $championship)
    {
        if ($championship->getAttributes()) {
            $this->id           = $championship->id;
            $this->title        = $championship->title;
            $this->nick         = $championship->nick;
            $this->type         = strtolower($championship->type);

            $this->logo_path    = $championship->logo_path;
            if ($this->logo_path) {
                $this->photo        = $championship->id . '/' . $championship->logo_path;
            }
        }
    }
    public function render()
    {
        return view('championship::livewire.admin.championship-edit')->layout('layouts.' . $this->layout);
    }

    public function save()
    {
        $id = $this->real_save();

        if ($id) {
            $championship = Championship::find($id);
            if ($championship->getAttributes()) {
                $this->championship         = $championship;
                $this->id           = $championship->id;
                $this->title        = $championship->title;
                $this->code         = $championship->code;
                $this->logo_path    = $championship->logo_path;
                if ($this->logo_path) {
                    $this->photo        = $championship->id . '/' . $championship->logo_path;
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
            'type'   => 'required',
        ];
        $this->validate();
        championship::updateOrCreate([
            'id'    => $this->id,
        ], [
            'title'     => $this->title,
            'nick'      => $this->nick,
            'type'   => $this->type,
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

            $directory = 'championships/' . $this->championship->id;
            $fullPath = storage_path('app/' . $directory);

            // Apaga apenas a imagem anterior, se existir
            if ($this->championship->logo_path) {
                Storage::delete($directory . '/' . $this->championship->logo_path);
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
                $this->championship->logo_path = $new_name;
                $this->championship->save();

                // Chamar a função logo
                $this->logo(
                    'championships/' . $this->championship->id . '/' . $new_name,
                    $this->championship->id,
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
        $this->championship->logo_path = '';
        $this->championship->save();
        if (Storage::directoryMissing('public/championships/' . $this->championship->id)) {
            Storage::makeDirectory('public/championships/' . $this->championship->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/championships/' . $this->championship->id);
        $this->photo = $this->championship->logo_path;
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
        $savePath = storage_path('app/public/championships/' . $id . '/');

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
