<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitsController extends Controller
{
    public function index()
    {
        return view('units.index');
    }

    public function show(Unit $unit)
    {
        return view('units.show', compact('unit'));
    }
}
