<?php

namespace App\Http\Livewire\Units;

use Livewire\Component;
use App\Models\Unit;
use App\Traits\SwalResponse;

class Tambah extends Component
{
    use SwalResponse;
    public $nama, $isUpdate = false, $unit;
    protected $listeners = ['setUpdate'];

    public function render()
    {
        return view('livewire.units.tambah');
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
        ]);

        try{

            $this->unit->update([
                'nama' => $this->nama,
            ]);

            $this->reset('nama');
            $this->isUpdate = false;
            $this->emit('refresh');
            $this->dispatchBrowserEvent('swal', $this->toastResponse('Data berhasil diubah'));
            // $this->dispatchBrowserEvent('hide-modal');

        }catch(\Exception $ex){
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
        ]);

        try{

            Unit::create([
                'nama' => $this->nama,
            ]);

            $this->reset('nama');
            $this->emit('refresh');
            $this->dispatchBrowserEvent('swal', $this->toastResponse('Data berhasil ditambahkan'));
            // $this->dispatchBrowserEvent('hide-modal');

        }catch(\Exception $ex){
            $this->dispatchBrowserEvent('swal', $this->toastResponse($ex->getMessage() ?? 'Data gagal ditambahkan', 'error'));
        }
    }
}
