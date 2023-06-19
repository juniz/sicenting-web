<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stuntingPerKec = $this->stuntingPerKec();
        $giziPerKab = $this->giziPerKab();
        $badanPerKab = $this->badanPerKab();
        $konsulPerKab = $this->konsulPerKab();

        $kabupaten = $stuntingPerKec->pluck('kabupaten');
        $jmlNormalKec = $stuntingPerKec->pluck('jmlNormal');
        $jmlSangatPendekKec = $stuntingPerKec->pluck('jmlSangatPendek');

        $jmlGiziKabupaten = $giziPerKab->pluck('kabupaten');
        $jmlGiziNormal = $giziPerKab->pluck('jmlGiziNormal');
        $jmlGiziBuruk = $giziPerKab->pluck('jmlGiziBuruk');
        $jmlObesitas = $giziPerKab->pluck('jmlObesitas');

        $badanKabupaten = $badanPerKab->pluck('kabupaten');
        $jmlBadanNormal = $badanPerKab->pluck('jmlBadanNormal');
        $jmlBadanKurang = $badanPerKab->pluck('jmlBadanKurang');

        $konsulKabupaten = $konsulPerKab->pluck('kabupaten');
        $jmlKonsul = $konsulPerKab->pluck('jmlKonsul');

        $jmlPendek = $this->jmlPendek();
        $jmlSangatPendek = $this->jmlSangatPendek();
        $jmlGiziLebih = $this->jmlGiziLebih();
        $jmlGiziKurang = $this->jmlGiziKurang();
        $jmlGiziBaik = $this->jmlGiziBaik();
        return view('dashboard.index', [
            'kabupaten' => $kabupaten,
            'jmlNormalKec' => $jmlNormalKec,
            'jmlSangatPendekKec' => $jmlSangatPendekKec,
            'jmlGiziKabupaten' => $jmlGiziKabupaten,
            'jmlGiziNormal' => $jmlGiziNormal,
            'jmlGiziBuruk' => $jmlGiziBuruk,
            'jmlObesitas' => $jmlObesitas,
            'badanKabupaten' => $badanKabupaten,
            'jmlBadanNormal' => $jmlBadanNormal,
            'jmlBadanKurang' => $jmlBadanKurang,
            'konsulKabupaten' => $konsulKabupaten,
            'jmlKonsul' => $jmlKonsul,
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
                    ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
                    ->selectRaw("regencies.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%normal%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%pendek%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlSangatPendek")
                    ->groupBy('balita.kabupaten')
                    ->get();
    }

    public function giziPerKab()
    {
        return DB::table('balita')
                    ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
                    ->selectRaw("regencies.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_tb like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%buruk%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziBuruk,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%Obesitas%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlObesitas")
                    ->groupBy('balita.kabupaten')
                    ->get();
    }

    public function badanPerKab()
    {
        return DB::table('balita')
                    ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
                    ->selectRaw("regencies.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_u like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%kurang%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanKurang")
                    ->groupBy('balita.kabupaten')
                    ->get();
    }

    public function konsulPerKab()
    {
        return DB::table('balita')
                    ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
                    ->selectRaw("regencies.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM konsul WHERE balita_id = balita.id LIMIT 1),0)) as jmlKonsul")
                    ->groupBy('balita.kabupaten')
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
