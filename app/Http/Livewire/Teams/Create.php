<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Team;
use Illuminate\Support\Str;

class Create extends Component
{
    use LivewireAlert;
    public $name, $telp, $jenis;

    public function render()
    {
        return view('livewire.teams.create');
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
            Team::create([
                'unit_id' => auth()->user()->unit_id,
                'name' => $this->name,
                'telp' => $this->telp,
                'jenis' => $this->jenis,
            ]);
            $this->reset(['name', 'telp', 'jenis']);
            $this->emit('refreshTable');
            $this->dispatchBrowserEvent('closeModal');
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
