<?php

namespace App\Http\Controllers\Standart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TBUPerempuan;

class TBUPerempuanController extends Controller
{
    public function index()
    {
        $tbu_perempuan = TBUPerempuan::all();
        $heads = ['Umur', '-3 SD', '-2 SD', '-1 SD', 'Median', '+1 SD', '+2 SD', '+3 SD'];
        return view('standart.tbu-perempuan', [
            'tbu_perempuan' => $tbu_perempuan,
            'heads' => $heads
        ]);
    }
}
