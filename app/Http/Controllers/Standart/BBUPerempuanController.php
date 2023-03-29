<?php

namespace App\Http\Controllers\Standart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BBUPerempuan;

class BBUPerempuanController extends Controller
{
    public function index()
    {
        $bbu_perempuan = BBUPerempuan::all();
        $heads = ['Umur', '-3 SD', '-2 SD', '-1 SD', 'Median', '+1 SD', '+2 SD', '+3 SD'];
        return view('standart.bbu-perempuan', [
            'bbu_perempuan' => $bbu_perempuan,
            'heads' => $heads
        ]);
    }
}
