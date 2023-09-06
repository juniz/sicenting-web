<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $q = $request->q;
        $kecamatan = $request->kecamatan;
        $kelurahan = Village::where('district_id', $kecamatan)->where('name', 'like', '%' . $q . '%')->get();
        return response()->json($kelurahan);
    }
}
