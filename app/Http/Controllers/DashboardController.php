<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stuntingPerKec = $this->stuntingPerKec();
        $kecamatan = $stuntingPerKec->pluck('kecamatan');
        $jmlPendekKec = $stuntingPerKec->pluck('jmlPendek');
        $jmlSangatPendekKec = $stuntingPerKec->pluck('jmlSangatPendek');
        $jmlPendek = $this->jmlPendek();
        $jmlSangatPendek = $this->jmlSangatPendek();
        $jmlGiziLebih = $this->jmlGiziLebih();
        $jmlGiziKurang = $this->jmlGiziKurang();
        $jmlGiziBaik = $this->jmlGiziBaik();
        return view('dashboard.index', [
            'kecamatan' => $kecamatan,
            'jmlPendekKec' => $jmlPendekKec,
            'jmlSangatPendekKec' => $jmlSangatPendekKec,
            'jmlPendek' => $jmlPendek->jml,
            'jmlSangatPendek' => $jmlSangatPendek->jml,
            'jmlGiziLebih' => $jmlGiziLebih->jml,
            'jmlGiziKurang' => $jmlGiziKurang->jml,
            'jmlGiziBaik' => $jmlGiziBaik->jml,
        ]);
    }

    public function stuntingPerKec()
    {
        return DB::table('balita')
                    ->selectRaw("balita.kecamatan,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u = 'Pendek'ORDER BY updated_at DESC LIMIT 1),0)) as jmlPendek,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u = 'Sangat pendek' ORDER BY updated_at DESC LIMIT 1),0)) as jmlSangatPendek")
                    ->groupBy('balita.kecamatan')
                    ->get();
    }

    public function jmlPendek()
    {
        return DB::table('pemeriksaan')
                    ->selectRaw("COUNT(*) as jml")
                    ->where('tb_u', 'Pendek')
                    // ->groupBy('pemeriksaan.balita_id')
                    ->orderByDesc('created_at')
                    ->first();
    }

    public function jmlSangatPendek()
    {
        return DB::table('pemeriksaan')
                    ->selectRaw("COUNT(*) as jml")
                    ->where('tb_u', 'Sangat pendek')
                    ->orderByDesc('created_at')
                    ->first();
    }

    public function jmlGiziLebih()
    {
        return DB::table('pemeriksaan')
                    ->selectRaw("COUNT(*) as jml")
                    ->where('bb_tb', 'Gizi lebih')
                    ->orWhere('bb_tb', 'Obesitas')
                    ->orderByDesc('created_at')
                    ->first();
    }

    public function jmlGiziKurang()
    {
        return DB::table('pemeriksaan')
                    ->selectRaw("COUNT(*) as jml")
                    ->where('bb_tb', 'Gizi kurang')
                    ->orWhere('bb_tb', 'Gizi sangat kurang')
                    ->orderByDesc('created_at')
                    ->first();
    }

    public function jmlGiziBaik()
    {
        return DB::table('pemeriksaan')
                    ->selectRaw("COUNT(*) as jml")
                    ->where('bb_tb', 'Gizi baik')
                    ->orderByDesc('created_at')
                    ->first();
    }
}
