<?php

namespace App\Http\Controllers\Standart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TBULaki;

class TBULakiController extends Controller
{
    public function index()
    {
        $tbu_laki = TBULaki::all();
        $heads = ['Umur', '-3 SD', '-2 SD', '-1 SD', 'Median', '+1 SD', '+2 SD', '+3 SD'];
        return view('standart.tbu-laki', [
            'tbu_laki' => $tbu_laki,
            'heads' => $heads
        ]);
    }
}
