<?php

namespace App\Http\Livewire\Units;

use App\Models\Province;
use Livewire\Component;
use App\Models\Unit;
use App\Traits\SwalResponse;

class Tambah extends Component
{
    use SwalResponse;
    public $nama, $isUpdate = false, $unit, $provinsi, $provinsi_id;
    protected $listeners = ['setUpdate'];

    public function render()
    {
        return view('livewire.units.tambah');
    }

    public function mount()
    {
        $this->provinsi = Province::all();
    }

    public function setUpdate($id)
    {
        $this->isUpdate = true;
        $this->unit = Unit::find($id);
        $this->nama = $this->unit->nama;
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'provinsi_id' => 'required',
        ]);

        try {

            $this->unit->update([
                'nama' => $this->nama,
                'provinsi_id' => $this->provinsi_id,
            ]);

            $this->reset('nama', 'provinsi_id');
            $this->isUpdate = false;
            $this->emit('refresh');
            $this->dispatchBrowserEvent('swal', $this->toastResponse('Data berhasil diubah'));
            // $this->dispatchBrowserEvent('hide-modal');

        } catch (\Exception $ex) {
            $this->dispatchBrowserEvent('swal', $this->toastResponse($ex->getMessage() ?? 'Data gagal diubah', 'error'));
        }
    }

    public function simpan()
    {
        $this->isUpdate ? $this->update() : $this->save();
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required',
            'provinsi_id' => 'required',
        ], [
            'provinsi_id.required' => 'Provinsi harus diisi',
            'nama.required' => 'Nama harus diisi',
        ]);

        try {

            $unit = new Unit();
            $unit->nama = $this->nama;
            $unit->province_id = $this->provinsi_id;
            $unit->save();

            $this->reset('nama', 'provinsi_id');
            $this->emit('refresh');
            $this->dispatchBrowserEvent('swal', $this->toastResponse('Data berhasil ditambahkan'));
            // $this->dispatchBrowserEvent('hide-modal');

        } catch (\Exception $ex) {
            $this->dispatchBrowserEvent('swal', $this->toastResponse($ex->getMessage() ?? 'Data gagal ditambahkan', 'error'));
        }
    }
}
