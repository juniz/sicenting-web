<?php

namespace App\Http\Livewire\Teams;

use App\Models\Team;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Table extends Component
{
    use LivewireAlert, WithPagination;
    public $search, $team_id;
    protected $queryString = ['search'];
    protected $listeners = ['refreshTable' => '$refresh', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.teams.table', [
            'teams' => Team::where('name', 'like', '%' . $this->search . '%')->where('unit_id', auth()->user()->unit->id)->get()
        ]);
    }

    public function mount()
    {
    }

    public function confirmDelete($id)
    {
        $this->team_id = $id;
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
            Team::find($this->team_id)->delete();
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
