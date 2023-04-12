<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $heads = ['No', 'Nama', 'JK', 'Tgl Lahir', 'Usia', 'Tgl Pengukuran', 'Berat', 'Tinggi', 'Lila', 'BB/U', 'ZS BB/U','TB/U', 'ZS TB/U', 'BB/TB', 'ZS BB/TB'];
        if(!empty($request->tanggal)){
            $tanggal = explode("-", $request->tanggal);
            $start = date('Y-m-d', strtotime($tanggal[0]));
            $end = date('Y-m-d', strtotime($tanggal[1]));
        }else{
            $start = date('Y-m-d');
            $end = date('Y-m-d');
        }
        $datas = DB::table('pemeriksaan')
                    ->join('balita', 'pemeriksaan.balita_id', '=', 'balita.id')
                    ->whereBetween('pemeriksaan.tgl_pengukuran', [$start, $end])
                    ->select('balita.nama', 'balita.jns_kelamin', 'balita.tgl_lahir', 'pemeriksaan.usia', 'pemeriksaan.created_at', 'pemeriksaan.berat', 'pemeriksaan.tinggi', 'pemeriksaan.lila', 'pemeriksaan.bb_u', 'pemeriksaan.zs_bbu','pemeriksaan.tb_u', 'zs_tbu', 'pemeriksaan.bb_tb', 'zs_bbtb')
                    ->get();
        return view('report.index', compact('heads', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
