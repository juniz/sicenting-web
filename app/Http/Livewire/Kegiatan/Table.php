<?php

namespace App\Http\Livewire\Kegiatan;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Kegiatan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Table extends Component
{
    use LivewireAlert, WithPagination;
    public $search, $kegiatan_id;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshTable' => '$refresh', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin')) {
            $data = Kegiatan::where('nama_kegiatan', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $data = Kegiatan::where('nama_kegiatan', 'like', '%' . $this->search . '%')->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('livewire.kegiatan.table', [
            'kegiatans' => $data
        ]);
    }

    public function confirmDelete($id)
    {
        $this->kegiatan_id = $id;
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
            Kegiatan::find($this->kegiatan_id)->delete();
            $this->emit('refreshTable');
            $this->alert('success', 'Data berhasil dihapus', [
                'toast' => false,
                'position' => 'center'
            ]);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage(), [
                'toast' => false,
                'position' => 'center'
            ]);
        }
    }
}
