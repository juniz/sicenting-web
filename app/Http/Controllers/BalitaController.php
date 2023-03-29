<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Balita;

class BalitaController extends Controller
{
    public function index()
    {
        $balita = Balita::all();
        return view('balita.index',[
            'balita' => $balita
        ]);
    }

    public function tambah()
    {
        return view('balita.tambah');
    }

    public function hapus($id)
    {
        $balita = Balita::find($id);
        $balita->delete();
        return redirect()->to('/balita');
    }

    public function detail($id)
    {
        return view('balita.detail',[
            'id' => $id,
            'balita' => Balita::find($id)
        ]);
    }
}
