<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('teams.index');
    }
}
