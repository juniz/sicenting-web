<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardKelController extends Controller
{
    public function index($id)
    {
        $param = $id;
        $kecamatan = District::where('id', $id)->first();
        return view('dashboard.kel', [
            'param' => $param,
            'kecamatan' => $kecamatan->name,
            'jmlBalita' => $this->getJmlBalita($param),
            'jmlBalitaIndikasiStunting' => $this->getJmlBalitaIndikasiStunting($param),
            'jmlBalitaStunting' => $this->getJmlBalitaStunting($param),
        ]);
    }

    public function stuntingPerKab($kec)
    {
        $data = DB::table('balita')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->selectRaw("villages.name as kabupaten, villages.id as id,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%normal%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlNormal,
                SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND tb_u like '%pendek%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlSangatPendek")
            ->where('balita.kecamatan', $kec)
            ->groupBy('balita.kelurahan')
            ->get();

        $response = [
            'param' => $data->pluck('id'),
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

    public function giziPerKab($kec)
    {
        $data = DB::table('balita')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->selectRaw("villages.name as kabupaten, villages.id as id,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_tb like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%buruk%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlGiziBuruk,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%Obesitas%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlObesitas")
            ->where('balita.kecamatan', $kec)
            ->groupBy('balita.kelurahan')
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

    public function badanPerKab($kec)
    {
        $data = DB::table('balita')
            ->join('villages', 'balita.kelurahan', '=', 'villages.id')
            ->selectRaw("villages.name as kabupaten, villages.id as id,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND ( bb_u like '%normal%' OR bb_tb like '%baik%' ) ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanNormal,
                    SUM(IFNULL((SELECT DISTINCT COUNT(*) FROM pemeriksaan WHERE balita_id = balita.id AND bb_tb like '%kurang%' ORDER BY updated_at DESC LIMIT 1),0)) as jmlBadanKurang")
            ->where('balita.kecamatan', $kec)
            ->groupBy('balita.kelurahan')
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

    public function getJmlBalita($param)
    {
        return Balita::where('kecamatan', $param)->count();
    }

    public function getJmlBalitaIndikasiStunting($param)
    {
        return DB::table('balita')
            ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
            ->whereRaw('pemeriksaan.created_at = (SELECT MAX(created_at) FROM pemeriksaan WHERE balita_id = balita.id)')
            ->where('kecamatan', $param)
            ->whereRaw("(LOWER(tb_u) like '%pendek%' OR LOWER(tb_u) like '%kurang%')")
            ->count();
    }

    public function getJmlBalitaStunting($param)
    {
        return DB::table('balita')
            ->join('pemeriksaan', 'balita.id', '=', 'pemeriksaan.balita_id')
            ->whereRaw('pemeriksaan.created_at = (SELECT MAX(created_at) FROM pemeriksaan WHERE balita_id = balita.id)')
            ->where('kecamatan', $param)
            ->whereRaw("(LOWER(tb_u) like '%pendek%' OR LOWER(tb_u) like '%kurang%')")
            ->whereRaw("LOWER(bb_u) like '%kurang%'")
            ->whereRaw("(LOWER(bb_tb) like '%kurang%' OR LOWER(bb_tb) like '%buruk%' OR LOWER(bb_tb) like '%obesitas%')")
            ->count();
    }
}
