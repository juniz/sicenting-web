<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request  $request)
    {
        $q = $request->q;
        $kabupaten = $request->kabupaten;
        $kecamatan = District::where('regency_id', $kabupaten)->where('name', 'like', '%' . $q . '%')->get();
        return response()->json($kecamatan);
    }
}
