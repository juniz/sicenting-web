<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Balita;
use App\Models\Pemeriksaan;
use Illuminate\Support\Str;

class Detail extends Component
{
    public $balita, $umur, $hasil;
    public function render()
    {
        return view('livewire.balita.detail');
    }

    public function mount($balita)
    {
        $this->balita = $balita;
        $this->hitungUmur();
        $this->hasil = $this->getHasilTerakhir();
    }

    public function hitungUmur()
    {
        $tglLahir = $this->balita->tgl_lahir;
        $tglSekarang = date('Y-m-d');
        $diff = date_diff(date_create($tglLahir), date_create($tglSekarang));
        $this->umur = $diff->format('%y Tahun %m Bulan %d Hari');
    }

    public function getHasilTerakhir()
    {
        return Pemeriksaan::where('balita_id', $this->balita->id)->orderBy('created_at', 'desc')->first();
    }

    public function hasilBBU($bbu)
    {
        if(Str::contains($bbu, 'kurang', true)){
            return 'Konsul ahli gizi';
        }
        return 'Normal';
    }

    public function hasilTBU($tbu)
    {
        if(Str::contains($tbu, 'pendek', true)){
            return 'Konsul dokter spesialis anak';
        }
        return 'Normal';
    }

    public function hasilBBTB($bbtb)
    {
        if(Str::contains($bbtb, 'buruk', true)){
            return 'Pemberian makanan tambahan (PMT)';
        }
        return 'Normal';
    }
}
