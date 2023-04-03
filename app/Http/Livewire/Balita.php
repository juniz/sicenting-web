<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Balita as BalitaModel;
use App\Traits\SwalResponse;
use Illuminate\Support\Arr;

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
        $this->kabupaten = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/regencies/' . $prov . '.json')->json();
        Arr::where($this->provinsi, function($value, $key){
            if($value['id'] == $this->selectProv){
                $this->valProv = $value['name'];
            }
        });
    }

    public function updatedSelectKab($kab)
    {
        $this->kecamatan = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/districts/' . $kab . '.json')->json();
        Arr::where($this->kabupaten, function($value, $key){
            if($value['id'] == $this->selectKab){
                $this->valKab = $value['name'];
            }
        });
    }

    public function updatedSelectKec($kec)
    {
        $this->kelurahan = Http::get('http://www.emsifa.com/api-wilayah-indonesia/api/villages/' . $kec . '.json')->json();
        Arr::where($this->kecamatan, function($value, $key){
            if($value['id'] == $this->selectKec){
                $this->valKec = $value['name'];
            }
        });
    }

    public function updatedSelectKel($kel)
    {
        Arr::where($this->kelurahan, function($value, $key){
            if($value['id'] == $this->selectKel){
                $this->valKel = $value['name'];
            }
        });
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
            'provinsi' => $this->valProv,
            'kabupaten' => $this->valKab,
            'kecamatan' => $this->valKec,
            'kelurahan' => $this->valKel,
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
