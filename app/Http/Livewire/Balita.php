<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Balita as BalitaModel;
use App\Traits\SwalResponse;

class Balita extends Component
{
    use SwalResponse;

    public BalitaModel $balita;
    public $provinsi = [], $selectProv = '', $kabupaten = [], $selectKab = '', $kecamatan = [], $selectKec = '', $kelurahan = [], $selectKel = '', $nama, $jnsKelamin, $tglLahir, $namaOrtu, $rt, $rw, $alamat, $valProv, $valKab, $valKec, $valKel;

    public function mount()
    {
        $this->balita = new BalitaModel();
        $this->provinsi = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
    }

    public function render()
    {
        return view('livewire.balita');
    }

    public function updatedSelectProv($prov)
    {
        $this->kabupaten = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/regencies/' . $this->selectProv . '.json')->json();
        $this->valProv = $prov;
    }

    public function updatedSelectKab()
    {
        $this->kecamatan = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/districts/' . $this->selectKab . '.json')->json();
    }

    public function updatedSelectKec()
    {
        $this->kelurahan = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/villages/' . $this->selectKec . '.json')->json();
    }

    public function clickProv($prov)
    {
       
    }

    public function clickKab($kab)
    {
        $this->selectKab = $kab;
    }

    public function clickKec($kec)
    {
        $this->selectKec = $kec;
    }

    public function clickKel($kel)
    {
        $this->selectKel = $kel;
    }

    public function simpan()
    {
        $this->validate([
            'selectProv' => 'required',
            'selectKab' => 'required',
            'selectKec' => 'required',
            'selectKel' => 'required',
            'nama' => 'required',
            'jnsKelamin' => 'required',
            'tglLahir' => 'required',
            'namaOrtu' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'alamat' => 'required',
        ]);

        $data = [
            'provinsi' => $this->selectProv,
            'kabupaten' => $this->selectKab,
            'kecamatan' => $this->selectKec,
            'kelurahan' => $this->selectKel,
            'nama' => strtoupper($this->nama),
            'jns_kelamin' => $this->jnsKelamin,
            'tgl_lahir' => $this->tglLahir,
            'nama_ortu' => strtoupper($this->namaOrtu),
            'rt' => $this->rt,
            'rw' => $this->rw,
            'alamat' => strtoupper($this->alamat),
            'user_id'   => auth()->user()->id
        ];

        try{

            BalitaModel::create($data);

            // $this->dispatchBrowserEvent('swal:balita', $this->toastResponse('Data berhasil ditambahkan'));
            return redirect()->to('/balita');

        }catch(\Exception $e){
                
            $this->dispatchBrowserEvent('swal:balita', $this->toastResponse($e->getMessage(), 'error'));
        }
    }
}
