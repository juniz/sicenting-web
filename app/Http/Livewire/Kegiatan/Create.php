<?php

namespace App\Http\Livewire\Kegiatan;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class Create extends Component
{
    use LivewireAlert, WithFileUploads;
    public $nama_kegiatan, $photo;

    public function render()
    {
        return view('livewire.kegiatan.create');
    }

    public function simpan()
    {
        $this->validate([
            'nama_kegiatan' => 'required',
            'photo' => 'required|image|max:2048',
        ], [
            'nama_kegiatan.required' => 'Nama Kegiatan tidak boleh kosong',
            'photo.required' => 'Photo tidak boleh kosong',
            'photo.image' => 'Photo harus berupa gambar',
            'photo.max' => 'Photo maksimal 2MB',
        ]);

        try {
            $fileName = auth()->user()->name . '-' . time() . '.' . $this->photo->extension();
            $this->photo->storeAs('public/kegiatan', $fileName);
            chmod(storage_path('app/public/kegiatan/' . $fileName), 0777);
            \App\Models\Kegiatan::create([
                'user_id' => auth()->user()->id,
                'nama_kegiatan' => $this->nama_kegiatan,
                'photo' => $fileName,
            ]);
            $this->reset(['nama_kegiatan', 'photo']);
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
