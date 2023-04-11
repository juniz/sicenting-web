<?php

namespace App\Http\Livewire\Select2;

use Livewire\Component;
use App\Models\Province;

class Provinsi extends Component
{
    public $provinsi = [], $selected = '';
    
    public function render()
    {
        return view('livewire.select2.provinsi');
    }

    public function mount()
    {
        $this->provinsi = Province::all();
    }
}
