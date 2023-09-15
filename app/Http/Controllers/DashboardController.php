<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $provinsi = auth()->user()->unit->provinsi ?? null;

        $jmlPendek = $this->jmlPendek();
        $jmlSangatPendek = $this->jmlSangatPendek();
        $jmlGiziLebih = $this->jmlGiziLebih();
        $jmlGiziKurang = $this->jmlGiziKurang();
        $jmlGiziBaik = $this->jmlGiziBaik();
        return view('dashboard.index', [
            'jmlPendek' => $jmlPendek->jml,
            'jmlSangatPendek' => $jmlSangatPendek->jml,
            'jmlGiziLebih' => $jmlGiziLebih->jml,
            'jmlGiziKurang' => $jmlGiziKurang->jml,
            'jmlGiziBaik' => $jmlGiziBaik->jml,
            'jmlBalita' => $this->getJmlBalita(),
            'jmlBalitaIndikasiStunting' => $this->getJmlBalitaIndikasiStunting(),
            'jmlBalitaStunting' => $this->getJmlBalitaStunting(),
        ]);
    }

    public function stunting($provinsi, $regencies, $stts)
    {
        switch ($stts) {
            case 'reg';
                return $this->stuntingPerKec($provinsi, $regencies);
                break;
            case 'dis':
                return $this->stuntingPerKel($provinsi, $regencies);
                break;
            default:
                return $this->stuntingPerKab($provinsi);
                break;
        }
        // return !empty($regencies) ? $this->stuntingPerKec($provinsi, $regencies) : $this->stuntingPerKab($provinsi);
    }

    public function stuntingPerKab()
    {
        $provinsi = auth()->user()->unit->provinsi;
        $data = DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('provinces', 'regencies.province_id', '=', 'provinces.id')
            ->selectRaw("regencies.name as kabupaten,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%normal%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlNormal,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%pendek%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlSangatPendek")
            ->where('provinces.id', $provinsi->id)
            ->groupBy('balita.kabupaten')
            ->get();

        $response = [
            'labels' => $data->pluck('kabupaten'),
            'datasets' => [
                [
                    'label'               => 'Tinggi Pendek',
                    'backgroundColor'     => 'rgb(242, 38, 19)',
                    'borderColor'         => 'rgb(242, 38, 19)',
                    'pointRadius'         => false,
                    'pointColor'          => 'rgb(242, 38, 19)',
                    'pointStrokeColor'    => '#c1c7d1',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(242, 38, 19)',
                    'data'                => $data->pluck('jmlSangatPendek')
                ],
                [
                    'label'               => 'Tinggi Normal',
                    'backgroundColor'     => 'rgb(46, 204, 113)',
                    'borderColor'         => 'rgb(46, 204, 113)',
                    'pointRadius'          => false,
                    'pointColor'          => '#3b8bba',
                    'pointStrokeColor'    => 'rgb(46, 204, 113)',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(46, 204, 113)',
                    'data'                => $data->pluck('jmlNormal')
                ]
            ]
        ];

        return response()->json($response);
    }

    public function stuntingPerKec($provinsi, $regencies)
    {
        return DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('districts', 'balita.kecamatan', '=', 'districts.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->selectRaw("districts.name as kabupaten,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND (LOWER(tb_u) like '%tinggi%' OR LOWER(tb_u) like '%normal%') ORDER BY updated_at DESC LIMIT 1),0)) as jmlNormal,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%pendek%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlSangatPendek")
            ->where('provinces.id', $provinsi->id)
            ->where('regencies.name',  $regencies)
            ->groupBy('balita.kecamatan')
            ->get();
    }

    public function stuntingPerKel($provinsi, $regencies)
    {
        return DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('districts', 'balita.kecamatan', '=', 'districts.id')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->selectRaw("villages.name as kabupaten,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND (LOWER(tb_u) like '%tinggi%' OR LOWER(tb_u) like '%normal%') ORDER BY updated_at DESC LIMIT 1),0)) as jmlNormal,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%pendek%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlSangatPendek")
            ->where('provinces.id', $provinsi->id)
            ->where('villages.name', $regencies)
            ->groupBy('balita.kelurahan')
            ->get();
    }

    public function gizi($provinsi, $regencies, $stts)
    {
        switch ($stts) {
            case 'reg';
                return $this->giziPerKec($provinsi, $regencies);
                break;
            case 'dis';
                return $this->giziPerKel($provinsi, $regencies);
                break;
            default:
                return $this->giziPerKab($provinsi);
                break;
        }
        // return !empty($regencies) ? $this->giziPerKec($provinsi, $regencies) : $this->giziPerKab($provinsi);
    }

    public function giziPerKab()
    {
        $provinsi = auth()->user()->unit->provinsi;
        $data = DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('provinces', 'regencies.province_id', '=', 'provinces.id')
            ->selectRaw("regencies.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_tb like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%buruk%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziBuruk,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%Obesitas%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlObesitas")
            ->where('provinces.id', $provinsi->id)
            ->groupBy('balita.kabupaten')
            ->get();

        $response = [
            'labels' => $data->pluck('kabupaten'),
            'datasets' => [
                [
                    'label'               => 'Obesitas',
                    'backgroundColor'     => 'rgb(52, 45, 113)',
                    'borderColor'         => 'rgb(52, 45, 113)',
                    'pointRadius'         => false,
                    'pointColor'          => 'rgb(52, 45, 113)',
                    'pointStrokeColor'    => '#c1c7d1',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(52, 45, 113)',
                    'data'                => $data->pluck('jmlObesitas')
                ],
                [
                    'label'               => 'Gizi Buruk',
                    'backgroundColor'     => 'rgb(242, 38, 19)',
                    'borderColor'         => 'rgb(242, 38, 19)',
                    'pointRadius'         => false,
                    'pointColor'          => 'rgb(242, 38, 19)',
                    'pointStrokeColor'    => '#c1c7d1',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(242, 38, 19)',
                    'data'                => $data->pluck('jmlGiziBuruk')
                ],
                [
                    'label'               => 'Gizi Normal',
                    'backgroundColor'     => 'rgb(46, 204, 113)',
                    'borderColor'         => 'rgb(46, 204, 113)',
                    'pointRadius'          => false,
                    'pointColor'          => '#3b8bba',
                    'pointStrokeColor'    => 'rgb(46, 204, 113)',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(46, 204, 113)',
                    'data'                => $data->pluck('jmlGiziNormal')
                ],
            ]
        ];

        return response()->json($response);
    }

    public function giziPerKec($provinsi, $regencies)
    {
        return DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('districts', 'balita.kecamatan', '=', 'districts.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->selectRaw("districts.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_tb like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%buruk%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziBuruk,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%Obesitas%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlObesitas")
            ->where('provinces.id', $provinsi->id)
            ->where('regencies.name', $regencies)
            ->groupBy('balita.kecamatan')
            ->get();
    }

    public function giziPerKel($provinsi, $regencies)
    {
        return DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('districts', 'balita.kecamatan', '=', 'districts.id')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->selectRaw("villages.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_tb like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%buruk%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziBuruk,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%Obesitas%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlObesitas")
            ->where('provinces.id', $provinsi->id)
            ->where('villages.name', $regencies)
            ->groupBy('balita.kelurahan')
            ->get();
    }

    public function badan($provinsi, $regencies, $stts)
    {
        switch ($stts) {
            case 'reg';
                return $this->badanPerKec($provinsi, $regencies);
                break;
            case 'dis';
                return $this->badanPerKel($provinsi, $regencies);
                break;
            default:
                return $this->badanPerKab($provinsi);
                break;
        }
        // return !empty($regencies) ? $this->badanPerKec($provinsi, $regencies) : $this->badanPerKab($provinsi);
    }

    public function badanPerKab()
    {
        $provinsi = auth()->user()->unit->provinsi;
        $data = DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('provinces', 'regencies.province_id', '=', 'provinces.id')
            ->selectRaw("regencies.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_u like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%kurang%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanKurang")
            ->where('provinces.id', $provinsi->id)
            ->groupBy('balita.kabupaten')
            ->get();

        $response = [
            'labels' => $data->pluck('kabupaten'),
            'datasets' => [
                [
                    'label'               => 'Berat Badan Kurang',
                    'backgroundColor'     => 'rgb(242, 38, 19)',
                    'borderColor'         => 'rgb(242, 38, 19)',
                    'pointRadius'         => false,
                    'pointColor'          => 'rgb(242, 38, 19)',
                    'pointStrokeColor'    => '#c1c7d1',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(242, 38, 19)',
                    'data'                => $data->pluck('jmlBadanKurang')
                ],
                [
                    'label'               => 'Berat Badan Normal',
                    'backgroundColor'     => 'rgb(46, 204, 113)',
                    'borderColor'         => 'rgb(46, 204, 113)',
                    'pointRadius'          => false,
                    'pointColor'          => '#3b8bba',
                    'pointStrokeColor'    => 'rgb(46, 204, 113)',
                    'pointHighlightFill'  => '#fff',
                    'pointHighlightStroke' => 'rgb(46, 204, 113)',
                    'data'                => $data->pluck('jmlBadanNormal')
                ],
            ]
        ];

        return response()->json($response);
    }

    public function badanPerKec($provinsi, $regencies)
    {
        return DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('districts', 'balita.kecamatan', '=', 'districts.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->selectRaw("districts.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_u like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%kurang%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanKurang")
            ->where('provinces.id', $provinsi->id)
            ->where('regencies.name', $regencies)
            ->groupBy('balita.kecamatan')
            ->get();
    }

    public function badanPerKel($provinsi, $regencies)
    {
        return DB::table('balita')
            ->join('regencies', 'balita.kabupaten', '=', 'regencies.id')
            ->join('districts', 'balita.kecamatan', '=', 'districts.id')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->selectRaw("villages.name as kabupaten,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_u like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%kurang%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanKurang")
            ->where('provinces.id', $provinsi->id)
            ->where('villages.name', $regencies)
            ->groupBy('balita.kelurahan')
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

    public function getJmkBalitaPerUser(Request $request)
    {
        $kel = $request->query('param');
        $provinsi = auth()->user()->unit->provinsi;
        $data = DB::table('users')
            ->join('balita', 'balita.user_id', '=', 'users.id')
            ->join('provinces', 'balita.provinsi', '=', 'provinces.id')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->selectRaw("users.name, COUNT(balita.id) as jmlBalita")
            ->where('balita.provinsi', $provinsi->id)
            ->where('villages.name', 'like', '%' . $kel . '%')
            ->groupBy('users.name')
            ->orderBy('jmlBalita', 'desc')
            ->get();
        $response = [
            'labels' => $data->pluck('name'),
            'datasets' => [
                [
                    'label' => 'Jumlah Balita',
                    'backgroundColor' => '#4e73df',
                    'borderColor' => '#4e73df',
                    'data' => $data->pluck('jmlBalita'),
                ],
            ],
        ];
        return response()->json($response);
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
}
