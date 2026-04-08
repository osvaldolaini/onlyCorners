<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Admin\Settings\Settings as Configs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Attributes\On;

class Settings extends Component
{
    use WithFileUploads;
    public $configs;
    public $id;
    public $name;
    public $nick;
    public $cpf_cnpj;
    public $postalCode;
    public $number;
    public $address;
    public $district;
    public $city;
    public $state;
    public $complement;
    public $board;
    public $airfield_codigoOaci;
    public $airfield_ciad;
    public $airfield_name;
    public $airfield_city;
    public $airfield_state;
    public $logo_path;
    public $contacts;
    public $chart_categories;

    public $rules;
    public $logo = '';
    public $uploadimage;

    public $rows = [];
    public $inputTypes = [];
    public $inputMask = [];

    public function mount()
    {
        $this->configs = Configs::find(1);
        $this->logo = Storage::directoryExists('public/logos-school');
        // if (isset($this->configs->logo_path)) {
        // $this->logo = 'logos-school/' . $this->configs->logo_path;
        $this->name = $this->configs->name;
        $this->nick = $this->configs->nick;
        $this->id = $this->configs->id;
        $this->cpf_cnpj = $this->configs->cpf_cnpj;
        $this->postalCode = $this->configs->postalCode;
        $this->number = $this->configs->number;
        $this->address = $this->configs->address;
        $this->district = $this->configs->district;
        $this->city = $this->configs->city;
        $this->state = $this->configs->state;
        $this->complement = $this->configs->complement;
        $this->logo_path = $this->configs->logo_path;
        // dd($this->configs->logo_path);
        // }
    }
    public function render()
    {
        return view('livewire.admin.settings.edit');
    }

    public function save()
    {
        $this->real_save();
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route('dashboard')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'name'         => 'required|min:4|max:255',
        ];

        $this->validate();

        $this->configs = Configs::updateOrCreate([
            'id'        => $this->id,
        ], [
            'name' => $this->name,
            'nick' => $this->nick,
            'cpf_cnpj' => $this->cpf_cnpj,
            'postalCode' => $this->postalCode,
            'number' => $this->number,
            'address' => $this->address,
            'district' => $this->district,
            'city' => $this->city,
            'state' => $this->state,
            'complement' => $this->complement,
            'logo_path' => $this->logo_path,
            'updated_by ' => Auth::user()->name,
        ]);

        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }

    /**Logo e favicons */
    public function excluirTemp()
    {
        $this->uploadimage = '';
    }
    public function excluirLogo()
    {
        $this->configs->logo_path = '';
        $this->configs->save();
        Storage::deleteDirectory('public/logos-school');
        Storage::deleteDirectory('public/favicons-school');
        $this->logo = $this->configs->logo_path;
    }
    public function updated($property)
    {
        //BUSCAR CEP
        if ($property === 'uploadimage') {
            $this->rules = [
                'uploadimage'   => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ];

            $this->validate();
            if (Storage::directoryMissing('public/logos-school')) {
                Storage::makeDirectory('public/logos-school', 0755, true, true);
            }

            if (isset($this->uploadimage)) {
                $code = Str::uuid();
                $new_name = $code . '.png';

                // $path = storage_path('app/public/logos-school');

                // // Verifica se o diretório existe e, se não, cria com permissão 755
                // if (!file_exists($path)) {
                //     mkdir($path, 0755, true);
                // }

                $this->uploadimage->storeAs('public/logos-school', $new_name);

                $this->configs->logo_path = $new_name;
                $this->configs->save();

                $this->logo('logos-school', $new_name);
            }
        }
        if ($property === 'postalCode') {
            $cep = str_replace('-', '', $this->postalCode);
            // dd($cep);
            $ch = curl_init("https://viacep.com.br/ws/" . $cep . "/json/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch));
            curl_close($ch);
            if ($result) {
                $this->address = $result->logradouro;
                $this->city = $result->localidade;
                $this->district = $result->bairro;
                $this->state = $result->uf;
            }
        }
    }

    public static function logo($path, $file)
    {

        $path_file = 'storage/' . $path . '/' . $file;
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($path_file);

        // $image = ImageManager::imagick()->read('images/example.jpg');
        // save modified image in new format
        $image->toPng()->save('storage/logos-school/logo.png');
        $image->toWebp()->save('storage/logos-school/logo.webp');
        $image->scale(width: 300);
        // Logos footer e Header
        $footer = $manager->read($path_file);
        $footer->scale(width: 300);
        $footer->toPng()->save('storage/logos-school/logo-footer.png');
        $footer->toWebp()->save('storage/logos-school/logo-footer.webp');

        $header = $manager->read($path_file);
        $header->scale(width: 130);
        $header->toPng()->save('storage/logos-school/logo-header.png');
        $header->toWebp()->save('storage/logos-school/logo-header.webp');

        if (Storage::directoryMissing('public/favicons-school')) {
            Storage::makeDirectory('public/favicons-school', 0755, true, true);
        }

        // $path_fav = storage_path('app/public/favicons-school');

        // // Verifica se o diretório existe e, se não, cria com permissão 755
        // if (!file_exists($path_fav)) {
        //     mkdir($path_fav, 0755, true);
        // }
        // Favicons
        $sizes = [
            [16, 'favicon-16x16'],
            [32, 'favicon-32x32'],
            [48, 'favicon'],
            [96, 'favicon-96x96'],
            [70, 'ms-icon-70x70'],
            [144, 'ms-icon-144x144'],
            [150, 'ms-icon-150x150'],
            [310, 'ms-icon-310x310'],
            [192, 'android-chrome-192x192'],
            [512, 'android-chrome-512x512'],
            [36, 'android-icon-36x36'],
            [48, 'android-icon-48x48'],
            [72, 'android-icon-72x72'],
            [96, 'android-icon-96x96'],
            [144, 'android-icon-144x144'],
            [192, 'android-icon-192x192'],
            [57, 'apple-icon-57x57'],
            [60, 'apple-icon-60x60'],
            [72, 'apple-icon-72x72'],
            [76, 'apple-icon-76x76'],
            [114, 'apple-icon-114x114'],
            [120, 'apple-icon-120x120'],
            [144, 'apple-icon-144x144'],
            [152, 'apple-icon-152x152'],
            [180, 'apple-icon-180x180'],
            [192, 'apple-icon'],
            [192, 'apple-icon-precomposed'],
            [180, 'apple-touch-icon'],
        ];
        foreach ($sizes as $fav) {
            $favicon = $manager->read($path_file);
            $favicon->scale(width: $fav[0]);
            $favicon->toPng()->save('storage/favicons-school/' . $fav[1] . '.png');
        }
    }


    public function closeAlert()
    {
        $this->dispatch('closeAlert');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
