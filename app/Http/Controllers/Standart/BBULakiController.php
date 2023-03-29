<?php

namespace App\Http\Controllers\Standart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BBULaki;

class BBULakiController extends Controller
{
    public function index()
    {
        $bbu_laki = BBULaki::all();
        $heads = ['Umur', '-3 SD', '-2 SD', '-1 SD', 'Median', '+1 SD', '+2 SD', '+3 SD'];
        return view('standart.bbu-laki', [
            'bbu_laki' => $bbu_laki,
            'heads' => $heads
        ]);
    }
}
