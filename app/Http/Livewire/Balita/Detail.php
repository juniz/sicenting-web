<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Balita;

class Detail extends Component
{
    public $balita, $umur;
    public function render()
    {
        return view('livewire.balita.detail');
    }

    public function mount($balita)
    {
        $this->balita = $balita;
        $this->hitungUmur();
    }

    public function hitungUmur()
    {
        $tglLahir = $this->balita->tgl_lahir;
        $tglSekarang = date('Y-m-d');
        $diff = date_diff(date_create($tglLahir), date_create($tglSekarang));
        $this->umur = $diff->format('%y Tahun %m Bulan %d Hari');
    }
}
