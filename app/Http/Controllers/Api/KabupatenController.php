<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use Illuminate\Http\Request;

class KabupatenController extends Controller
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
        $provinsi = $request->provinsi;
        $kabupaten = Regency::where('province_id', $provinsi)->where('name', 'like', '%' . $q . '%')->get();
        return response()->json($kabupaten);
    }
}
