<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TBULaki;

class TBULakiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach($request->all() as $req){
            try{
                TBULaki::create([
                    'tb' => $req['tb'],
                    'min3sd' => $req['min3SD'],
                    'min2sd' => $req['min2SD'],
                    'min1sd' => $req['min1SD'],
                    'median' => $req['median'],
                    'plus1sd' => $req['plus1SD'],
                    'plus2sd' => $req['plus2SD'],
                    'plus3sd' => $req['plus3SD'],
                ]);

            }catch(\Exception $e){
                return response()->json([
                    'message' => 'Gagal menambahkan data',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Berhasil menambahkan data'
        ], 200);
    }
}
