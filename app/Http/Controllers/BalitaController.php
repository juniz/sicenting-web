<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Balita;

class BalitaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:Super Admin', ['only' => ['index']]);
    }

    public function index()
    {
        $balita = Balita::orderBy('updated_at', 'DESC')->get();
        $config = ['ordering'   =>  false];
        return view('balita.index',[
            'balita' => $balita,
            'config' => $config
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
