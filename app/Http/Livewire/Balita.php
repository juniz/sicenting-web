<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Balita as BalitaModel;
use App\Models\District;
use App\Traits\SwalResponse;
use Illuminate\Support\Arr;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;

class Balita extends Component
{
    use SwalResponse;

    public BalitaModel $balita;
    public $provinsi = [], $selectProv = '', $kabupaten = [], $selectKab = '', $kecamatan = [], $selectKec = '', $kelurahan = [], $selectKel = '', $nama, $jnsKelamin, $tglLahir, $namaOrtu, $rt, $rw, $alamat, $valProv, $valKab, $valKec, $valKel;

    protected $listeners = ['updatedSelectKab'];

    public function mount()
    {
        $this->balita = new BalitaModel();
        $this->provinsi = Province::all();
    }

    public function render()
    {
        return view('livewire.balita');
    }

    public function updatedSelectProv()
    {
        $this->kabupaten = Regency::where('province_id', $this->selectProv)->get();
        // $this->dispatchBrowserEvent('selectProv');
    }

    public function updatedSelectKab()
    {
        $this->kecamatan = District::where('regency_id', $this->selectKab)->get();
        $this->dispatchBrowserEvent('selectKab');
    }

    public function updatedSelectKec()
    {
        $this->kelurahan = Village::where('district_id', $this->selectKec)->get();
        $this->dispatchBrowserEvent('selectKec');
    }

    public function updatedSelectKel($kel)
    {
        // Arr::where($this->kelurahan, function($value, $key){
        //     if($value['id'] == $this->selectKel){
        //         $this->valKel = $value['name'];
        //     }
        // });
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
            // 'selectProv' => 'required',
            // 'selectKab' => 'required',
            // 'selectKec' => 'required',
            // 'selectKel' => 'required',
            'nama' => 'required',
            'jnsKelamin' => 'required',
            'tglLahir' => 'required',
            'namaOrtu' => 'required',
            // 'rt' => 'required',
            // 'rw' => 'required',
            // 'alamat' => 'required',
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

            $cek = BalitaModel::where('nama', $this->nama)->where('tgl_lahir', $this->tglLahir)->where('nama_ortu', strtoupper($this->namaOrtu))->first();

            if($cek){
                $this->dispatchBrowserEvent('swal:balita', $this->toastResponse('Data sudah ada', 'error'));
                return;
            }else{
                BalitaModel::create($data);

                // $this->dispatchBrowserEvent('swal:balita', $this->toastResponse('Data berhasil ditambahkan'));
                return redirect()->to('/balita');
            }
            

        }catch(\Exception $e){
                
            $this->dispatchBrowserEvent('swal:balita', $this->toastResponse($e->getMessage(), 'error'));
        }
    }
}
