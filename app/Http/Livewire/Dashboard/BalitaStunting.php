<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Balita;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;

class BalitaStunting extends Component
{
    use WithPagination, LivewireAlert;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = $this->search;
        return view('livewire.dashboard.balita-stunting', [
            'balitas' => DB::table('balita')
                ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
                ->where('balita.provinsi', auth()->user()->unit->province_id)
                ->whereRaw('pemeriksaan.created_at = (SELECT MAX(created_at) FROM pemeriksaan WHERE balita_id = balita.id)')
                ->where(function ($query) use ($search) {
                    $query->where('pemeriksaan.tb_u', 'like', '%pendek%')
                        ->orWhere('pemeriksaan.tb_u', 'like', '%kurang%');
                })
                ->whereRaw("LOWER(bb_u) like '%kurang%'")
                ->whereRaw("(LOWER(bb_tb) like '%kurang%' OR LOWER(bb_tb) like '%buruk%' OR LOWER(bb_tb) like '%obesitas%')")
                ->where(function ($query) use ($search) {
                    $query->where('balita.nama', 'like', '%' . $search . '%')
                        ->orWhere('balita.nik', 'like', '%' . $search . '%');
                })
                ->orderBy('pemeriksaan.updated_at', 'desc')->paginate(10)
        ]);
    }
}
