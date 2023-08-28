<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Balita;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Province;

class Table extends Component
{
    use WithPagination, LivewireAlert;
    public $search, $idBalita;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshTable' => '$refresh', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.balita.table', [
            'balitas' => Balita::where('nama', 'like', '%' . $this->search . '%')->orWhere('nik', 'like', '%' . $this->search . '%')->orderBy('updated_at', 'desc')->paginate(10)
        ]);
    }

    public function mount()
    {
    }

    public function modalTambahBalita()
    {
        $this->dispatchBrowserEvent('openModalTambahBalita');
    }

    public function modalUpdateBalita($id)
    {
        $this->emit('getBalita', $id);
    }

    public function confirmDelete($id)
    {
        $this->idBalita = $id;
        $this->confirm('Yakin ingin menghapus data ini?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => '<i class="fas fa-times"></i> Batal',
            'onConfirmed' => 'delete',
        ]);
    }

    public function delete()
    {
        try {
            $balita = Balita::find($this->idBalita);
            $balita->delete();
            $this->emit('refreshTable');
            $this->reset('idBalita');
            $this->alert('success', 'Data berhasil dihapus', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  false,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Data gagal dihapus', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  false,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
    }
}
