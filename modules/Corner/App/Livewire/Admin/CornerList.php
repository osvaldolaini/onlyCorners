<?php

namespace Modules\Corner\App\Livewire\Admin;

use Livewire\Component;
use Modules\Corner\App\Models\Corner;
use Modules\Game\App\Models\Game;

use Illuminate\Validation\Rule;
use Livewire\Attributes\On;


use Illuminate\Support\Str;

class CornerList extends Component
{
    // Define o layout a ser usado
    protected $layout = 'app';

    public $breadcrumb = 'Escanteios do jogo:';
    public $game;
    public $corners;
    public $half;
    public $min;
    public $favored_id;

    public function mount(Game $game)
    {
        $this->game = $game;
        $this->corners = $game->corners;
        $this->half = $game->half;
        $this->min = $game->min;
        $this->favored_id = $game->favored_id;
        // dd($this->game);
    }
    public function render()
    {
        return view('corner::livewire.admin.corner-list')->layout('layouts.' . $this->layout);
        $this->corners = $this->corners;
    }
    public function addRow()
    {
        Corner::create([
            'active'            => 1,
            'date'              => $this->game->date,
            'hour'              => $this->game->hour,
            'game_id'           => $this->game->id,
            'team_id'           => $this->game->team_id,
            'opponent_id'       => $this->game->opponent_id,
            'championship_id'   => $this->game->championship_id,
            'code'              => Str::uuid(),
        ]);
        $this->loadCorners();
        $this->openAlert('success', 'Adicionado com sucesso');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    private function loadCorners()
    {
        $this->corners = $this->game->corners()
            ->with(['team', 'opponent'])   // carrega os relacionamentos necessários
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function removeRow($id)
    {
        $corners = Corner::find($id);
        $corners->delete();
        $this->loadCorners();
        $this->openAlert('success', 'Removido com sucesso');
    }
    public function updateCornerHalf(Corner $corner, $val)
    {
        $corner->half = $val;

        $corner->save();
        $this->loadCorners();
        $this->openAlert('success', 'Editado com sucesso');
        // dd($val, $corner);
    }
    public function updated($property)
    {
        if ($property === 'contact') {
            Corner::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'contact' => $this->contact,
            ]);
        }
        if ($property === 'parent') {
            Corner::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'parent' => $this->parent,
            ]);
        }
        if ($property === 'type') {
            Corner::updateOrCreate([
                'id'    => $this->data->id,
            ], [
                'type' => $this->type,
            ]);
        }
    }
    public function updatedContacts($value, $fieldPath)
    {
        [$index, $field] = explode('.', $fieldPath);
        $contactData = $this->contacts[$index] ?? null;

        if (!$contactData || empty($contactData['id'])) return;

        // $rules = [
        //     'parent' => 'nullable|string|max:255',
        //     'type' => 'required|string',
        //     'contact' => 'required|string|in:email,mobile',
        // ];

        $this->validate([
            "contacts.$index.$field" => $rules[$field] ?? 'nullable',
        ]);

        Corner::where('id', $contactData['id'])->update([
            $field => strtolower($value),
        ]);
    }
}
