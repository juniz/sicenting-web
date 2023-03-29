<?php

namespace App\Http\Controllers\Standart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TBBBLakiController extends Controller
{
    public function index()
    {
        return view('standart.tbbb-laki');
    }
}
