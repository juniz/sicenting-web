<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Balita;
use App\Models\Province;
use App\Imports\BalitaImport;
use Excel;
use Illuminate\Support\Facades\DB;

class BalitaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:Super Admin', ['only' => ['index']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin')) {
            // $balita = Balita::orderBy('updated_at', 'DESC')->get();
            $balita = DB::table('balita')
                ->join('users', 'balita.user_id', '=', 'users.id')
                ->join('unit', 'users.unit_id', '=', 'unit.id')
                ->where('unit.id', auth()->user()->unit->id)
                ->select('balita.*')
                ->orderBy('balita.updated_at', 'DESC')
                ->get();
        } else {
            $balita = Balita::where('user_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->get();
        }
        $provinsi = Province::all();
        $config = ['ordering'   =>  false];
        return view('balita.index', [
            'balita' => $balita,
            'config' => $config,
            'provinsi' => $provinsi
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa excel'
        ]);

        $data = Excel::import(new BalitaImport, $request->file('file')->store('files'));

        return redirect()->to('/balita')->with('success', 'Data berhasil diimport');
    }

    public function tambah()
    {
        $provinsi = Province::all();
        return view('balita.tambah', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:balita|min:16|numeric',
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
        ], [
            'nik.required' => 'KK tidak boleh kosong',
            'nik.unique' => 'KK sudah terdaftar',
            'nik.min' => 'KK minimal 16 digit',
            'nik.numeric' => 'KK harus berupa angka',
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

        try {

            $balita = new Balita;
            $balita->user_id = auth()->user()->id;
            $balita->nik = $request->nik;
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() ?? 'Terjadi kesalahan');
        }
    }

    public function hapus($id)
    {
        try {

            $balita = Balita::find($id);
            $balita->delete();
            return redirect()->to('/balita')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function detail($id)
    {
        return view('balita.detail', [
            'id' => $id,
            'balita' => Balita::find($id)
        ]);
    }
}
