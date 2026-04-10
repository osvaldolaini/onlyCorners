<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Parsedown;

class ReadmeView extends Component
{
    public $readmeContent;

    // Define o layout a ser usado
    protected $layout = 'app';
    public function mount()
    {
        $path = base_path('VERSIONS.md'); // Caminho do arquivo
        $this->readmeContent = File::exists($path)
            ? (new Parsedown())->text(File::get($path))
            : 'Arquivo README.md não encontrado.';
    }

    public function render()
    {
        return view('livewire.readme-view')->layout('layouts.' . $this->layout);
    }
}
