<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Update extends Component
{
    use LivewireAlert;
    public $name, $telp, $jenis, $team;
    protected $listeners = ['openEditModal'];

    public function render()
    {
        return view('livewire.teams.update');
    }

    public function openEditModal($id)
    {
        $this->team = \App\Models\Team::find($id);
        $this->name = $this->team->name;
        $this->telp = $this->team->telp;
        $this->jenis = $this->team->jenis;
        $this->dispatchBrowserEvent('openEditModal');
    }

    public function simpan()
    {
        $this->validate([
            'name' => 'required',
            'telp' => 'required|numeric',
            'jenis' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'telp.required' => 'Telp tidak boleh kosong',
            'telp.numeric' => 'Telp harus berupa angka',
            'jenis.required' => 'Jenis tidak boleh kosong',
        ]);

        try {
            $this->team->update([
                'name' => $this->name,
                'telp' => $this->telp,
                'jenis' => $this->jenis,
            ]);
            $this->reset(['name', 'telp', 'jenis']);
            $this->emit('refreshTable');
            $this->dispatchBrowserEvent('closeEditModal');
            $this->alert('success', 'Data berhasil disimpan', [
                'toast' => false,
                'position' => 'center'
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal simpan data', [
                'toast' => false,
                'position' => 'center'
            ]);
        }
    }
}
