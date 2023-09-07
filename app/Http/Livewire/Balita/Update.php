<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use App\Models\Balita;

class Update extends Component
{
    use LivewireAlert;
    public $provinsi, $valProvinsi, $nama, $nik, $jns_kelamin, $tgl_lahir, $nama_ortu, $rt, $rw, $alamat, $idBalita;
    public $balita;
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
        $this->balita = Balita::find($id);
        $this->idBalita = $this->balita->id;
        $this->nama = $this->balita->nama;
        $this->nik = $this->balita->nik;
        $this->jns_kelamin = $this->balita->jns_kelamin;
        $this->tgl_lahir = $this->balita->tgl_lahir;
        $this->nama_ortu = $this->balita->nama_ortu;
        $this->rt = $this->balita->rt;
        $this->rw = $this->balita->rw;
        $this->alamat = $this->balita->alamat;
        $this->dispatchBrowserEvent('openModalUpdateBalita');
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'nik' => 'required|min:16|max:16|regex:/^[0-9]+$/',
            'jns_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'nama_ortu' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'alamat' => 'required',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nik.required' => 'No.KK tidak boleh kosong',
            'nik.min' => 'No.KK harus 16 digit',
            'nik.max' => 'No.KK harus 16 digit',
            'nik.regex' => 'NIK harus berupa angka',
            'jns_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
            'nama_ortu.required' => 'Nama Orang Tua tidak boleh kosong',
            'rt.required' => 'RT tidak boleh kosong',
            'rw.required' => 'RW tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
        ]);

        try {

            $this->balita->update([
                'nama' => Str::upper($this->nama),
                'nik' => $this->nik,
                'jns_kelamin' => $this->jns_kelamin,
                'tgl_lahir' => $this->tgl_lahir,
                'nama_ortu' => Str::upper($this->nama_ortu),
                'rt' => $this->rt,
                'rw' => $this->rw,
                'alamat' => Str::upper($this->alamat),
            ]);

            $this->reset(['nama', 'nik', 'jns_kelamin', 'tgl_lahir', 'nama_ortu', 'rt', 'rw', 'alamat']);
            $this->emit('refreshTable');
            $this->dispatchBrowserEvent('closeModalUpdateBalita');
            $this->alert('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error', 'Data gagal diubah', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  false,
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
            ]);
        }
    }
}
