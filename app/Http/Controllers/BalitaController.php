<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Balita;
use App\Models\Province;

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
        $provinsi = Province::all();
        return view('balita.tambah', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tglLahir' => 'required',
            'jnsKelamin' => 'required',
            'namaOrtu' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'alamat' => 'required',
        ],[
            'nama.required' => 'Nama balita tidak boleh kosong',
            'tglLahir.required' => 'Tanggal lahir tidak boleh kosong',
            'jnsKelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'namaOrtu.required' => 'Nama orang tua tidak boleh kosong',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong',
            'kecamatan.required' => 'Kecamatan tidak boleh kosong',
            'kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'rt.required' => 'RT tidak boleh kosong',
            'rw.required' => 'RW tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
        ]);

        try{

            $balita = new Balita;
            $balita->user_id = auth()->user()->id;
            $balita->nama = Str::upper($request->nama);
            $balita->tgl_lahir = $request->tglLahir;
            $balita->jns_kelamin = $request->jnsKelamin;
            $balita->nama_ortu = Str::upper($request->namaOrtu);
            $balita->alamat = Str::upper($request->alamat);
            $balita->provinsi = $request->provinsi;
            $balita->kabupaten = $request->kabupaten;
            $balita->kecamatan = $request->kecamatan;
            $balita->kelurahan = $request->kelurahan;
            $balita->rt = $request->rt;
            $balita->rw = $request->rw;
            $balita->save();
    
            return redirect()->to('/balita')->with('success', 'Data berhasil ditambahakan');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage() ?? 'Terjadi kesalahan');
        }

    }

    public function hapus($id)
    {
        try{

            $balita = Balita::find($id);
            $balita->delete();
            return redirect()->to('/balita')->with('success', 'Data berhasil dihapus');

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage() ?? 'Terjadi kesalahan');
        }
    }

    public function detail($id)
    {
        return view('balita.detail',[
            'id' => $id,
            'balita' => Balita::find($id)
        ]);
    }
}
