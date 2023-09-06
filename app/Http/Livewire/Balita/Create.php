<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Province;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;

class Create extends Component
{
    use LivewireAlert;
    public $provinsi, $valProvinsi, $nama, $nik, $jns_kelamin, $tgl_lahir, $nama_ortu, $kabupaten, $kecamatan, $kelurahan, $rt, $rw, $alamat;
    protected $listeners = ['resetAll'];
    public function render()
    {
        return view('livewire.balita.create');
    }

    public function mount($provinsi)
    {
        $this->provinsi = $provinsi;
    }

    public function resetAll()
    {
        $this->reset(['nama', 'nik', 'jns_kelamin', 'tgl_lahir', 'nama_ortu', 'kabupaten', 'kecamatan', 'kelurahan', 'rt', 'rw', 'alamat']);
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'nik' => 'required|unique:balita,nik|min:16|max:16|regex:/^[0-9]+$/',
            'jns_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'nama_ortu' => 'required',
            'valProvinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.min' => 'NIK harus 16 digit',
            'nik.max' => 'NIK harus 16 digit',
            'nik.regex' => 'NIK harus berupa angka',
            'jns_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
            'nama_ortu.required' => 'Nama Orang Tua tidak boleh kosong',
            'valProvinsi.required' => 'Provinsi tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            'kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'rt.required' => 'RT tidak boleh kosong',
            'rw.required' => 'RW tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
        ]);

        try {
            $balita = new \App\Models\Balita;
            $balita->user_id = auth()->user()->id;
            $balita->nama = Str::upper($this->nama);
            $balita->nik = $this->nik;
            $balita->jns_kelamin = $this->jns_kelamin;
            $balita->tgl_lahir = $this->tgl_lahir;
            $balita->nama_ortu = Str::upper($this->nama_ortu);
            $balita->provinsi = $this->valProvinsi;
            $balita->kabupaten = $this->kabupaten;
            $balita->kecamatan = $this->kecamatan;
            $balita->kelurahan = $this->kelurahan;
            $balita->rt = $this->rt;
            $balita->rw = $this->rw;
            $balita->alamat = $this->alamat;
            $balita->save();
            $this->except(['provinsi']);
            $this->emit('refreshTable');
            $this->dispatchBrowserEvent('closeModalTambahBalita');
            $this->alert('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            $this->alert('error', 'Data gagal disimpan');
        }
    }
}
