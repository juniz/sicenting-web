<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use Illuminate\Support\Carbon;

class Pemeriksaan extends Component
{
    public $tanggal;
    public $tinggi, $berat, $idBalita;
    protected $listeners = ['openModalPemeriksaan'];

    public function mount()
    {
        $this->tanggal = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.balita.pemeriksaan');
    }

    public function openModalPemeriksaan($id)
    {
        $this->idBalita = $id;
        $this->dispatchBrowserEvent('openModalPemeriksaan');
    }
}
