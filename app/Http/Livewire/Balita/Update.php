<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use App\Models\Balita;

class Update extends Component
{
    use LivewireAlert;
    public $provinsi, $valProvinsi, $nama, $nik, $jns_kelamin, $tgl_lahir, $nama_ortu, $kabupaten, $kecamatan, $kelurahan, $rt, $rw, $alamat, $idBalita;
    protected $listeners = ['getBalita'];

    public function render()
    {
        return view('livewire.balita.update');
    }

    public function mount($provinsi)
    {
        $this->provinsi = $provinsi;
    }

    public function getBalita($id)
    {
        $balita = Balita::find($id);
        $this->idBalita = $balita->id;
        $this->nama = $balita->nama;
        $this->nik = $balita->nik;
        $this->jns_kelamin = $balita->jns_kelamin;
        $this->tgl_lahir = $balita->tgl_lahir;
        $this->nama_ortu = $balita->nama_ortu;
        $this->rt = $balita->rt;
        $this->rw = $balita->rw;
        $this->alamat = $balita->alamat;
        $this->dispatchBrowserEvent('openModalUpdateBalita');
    }
}
