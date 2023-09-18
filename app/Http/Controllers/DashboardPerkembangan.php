<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Balita;
use App\Models\Pemeriksaan;

class DashboardPerkembangan extends Controller
{
    public function index()
    {
        $tahun = range(date('Y'), 2020);
        return view('dashboard.perkembangan', [
            'jmlBalita' => $this->getJmlBalita(),
            'jmlBalitaIndikasiStunting' => $this->getJmlBalitaIndikasiStunting(),
            'jmlBalitaStunting' => $this->getJmlBalitaStunting(),
            'tahun' => $tahun
        ]);
    }

    public function getJmlBalita()
    {
        return Balita::where('provinsi', auth()->user()->unit->provinsi->id)->count();
    }

    public function getJmlBalitaIndikasiStunting()
    {
        return DB::table('balita')
            ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
            ->whereRaw('pemeriksaan.created_at = (SELECT MAX(created_at) FROM pemeriksaan WHERE balita_id = balita.id)')
            ->where('provinsi', auth()->user()->unit->provinsi->id)
            ->whereRaw("(LOWER(tb_u) like '%pendek%' OR LOWER(tb_u) like '%kurang%')")
            ->count();
    }

    public function getJmlBalitaStunting()
    {
        return DB::table('balita')
            ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
            ->whereRaw('pemeriksaan.created_at = (SELECT MAX(created_at) FROM pemeriksaan WHERE balita_id = balita.id)')
            ->where('provinsi', auth()->user()->unit->provinsi->id)
            ->whereRaw("(LOWER(tb_u) like '%pendek%' OR LOWER(tb_u) like '%kurang%')")
            ->whereRaw("LOWER(bb_u) like '%kurang%'")
            ->whereRaw("(LOWER(bb_tb) like '%kurang%' OR LOWER(bb_tb) like '%buruk%' OR LOWER(bb_tb) like '%obesitas%')")
            ->count();
    }

    public function grafikPerkembangan(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        $data = DB::table('pemeriksaan')
            ->join('balita', 'pemeriksaan.balita_id', '=', 'balita.id')
            ->selectRaw('MONTHNAME(tgl_pengukuran) as bulan, COUNT(*) as jml')
            ->whereYear('tgl_pengukuran', $tahun)
            ->where('balita.provinsi', auth()->user()->unit->provinsi->id)
            ->whereRaw("(LOWER(tb_u) like '%kurang%' OR LOWER(tb_u) like '%pendek%')")
            ->whereRaw("LOWER(bb_u) like '%kurang%'")
            ->whereRaw("(LOWER(bb_tb) like '%kurang%' OR LOWER(bb_tb) like '%buruk%' OR LOWER(bb_tb) like '%obesitas%')")
            ->groupByRaw('MONTHNAME(tgl_pengukuran)')
            ->orderByRaw('MONTH(tgl_pengukuran)')
            ->get();

        $response = [
            'labels' => $data->pluck('bulan'),
            'datasets' => [
                [
                    'label' => 'Kasus Stunting',
                    'data' => $data->pluck('jml'),
                    'backgroundColor' => '#4e73df',
                    'borderColor' => '#4e73df',
                    'fill' => false,
                ]
            ]
        ];

        return response()->json($response);
    }

    public function getJenisUser()
    {
        $data = DB::table('users')
            ->join('balita', 'users.id', '=', 'balita.user_id')
            ->selectRaw('users.jenis, COUNT(balita.id) as jml')
            ->where('balita.provinsi', auth()->user()->unit->provinsi->id)
            ->groupByRaw('users.jenis')
            ->get();
        $response = [
            'labels' => $data->pluck('jenis'),
            'datasets' => [
                [
                    'label' => 'Jenis User',
                    'data' => $data->pluck('jml'),
                    'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc'],
                    'borderColor' => ['#4e73df', '#1cc88a', '#36b9cc'],
                    'fill' => false,
                ]
            ]
        ];

        return response()->json($response);
    }

    public function getUserJns(Request $request)
    {
        $jns = $request->jns ?? 'all';
        $data = DB::table('users')
            ->join('balita', 'users.id', '=', 'balita.user_id')
            ->selectRaw('users.name, COUNT(balita.id) as jml')
            ->where('balita.provinsi', auth()->user()->unit->provinsi->id)
            ->when($jns != 'all', function ($query) use ($jns) {
                return $query->where('users.jenis', $jns);
            })
            ->groupByRaw('users.name')
            ->orderBy('jml', 'desc')
            ->get();

        $response = [
            'labels' => $data->pluck('name'),
            'datasets' => [
                [
                    'label' => 'Jenis Balita',
                    'data' => $data->pluck('jml'),
                    'backgroundColor' => '#1cc88a',
                    'borderColor' => '#1cc88a',
                    'fill' => false,
                ]
            ]
        ];

        return response()->json($response);
    }
}
