<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Balita;
use App\Models\Konsul;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TableKonsul extends Component
{
    use WithPagination;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = $this->search;
        if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin')) {
            $data = DB::table('balita')
                ->join('konsul', 'balita.id', '=', 'konsul.balita_id')
                ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
                ->whereRaw('pemeriksaan.created_at = (SELECT MAX(a.created_at) FROM pemeriksaan a WHERE balita_id = balita.id)')
                ->where('balita.provinsi', auth()->user()->unit->province_id)
                ->where(function ($query) use ($search) {
                    $query->where('balita.nama', 'like', '%' . $search . '%')
                        ->orWhere('balita.nik', 'like', '%' . $search . '%');
                })
                ->paginate(10);
        } else {
            $data = DB::table('balita')
                ->join('konsul', 'balita.id', '=', 'konsul.balita_id')
                ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
                ->whereRaw('pemeriksaan.created_at = (SELECT MAX(a.created_at) FROM pemeriksaan a WHERE balita_id = balita.id)')
                ->where('user_id', auth()->user()->id)
                ->where(function ($query) use ($search) {
                    $query->where('balita.nama', 'like', '%' . $search . '%')
                        ->orWhere('balita.nik', 'like', '%' . $search . '%');
                })
                ->paginate(10);
        }

        return view('livewire.balita.table-konsul', [
            'balitas' => $data
        ]);
    }
}
