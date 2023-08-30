<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kegiatan;
use PDF;
use Illuminate\Support\Carbon;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->hasRole('super-admin')) {
            $users = User::where('id', '!=', auth()->user()->id)->get();
        } else if (auth()->user()->hasRole('admin')) {
            $users = User::where('unit_id', auth()->user()->unit->id)->get();
        } else {
            $users = User::where('id', auth()->user()->id)->get();
        }
        return view('kegiatan.index', [
            'users' => $users
        ]);
    }

    public function cetak(Request $request)
    {
        $tanggal = explode("-", $request->tanggal);
        $tanggal_awal = Carbon::parse($tanggal[0])->format('Y-m-d H:m:s') ?? date('Y-m-d');
        $tanggal_akhir = Carbon::parse($tanggal[1])->format('Y-m-d H:m:s') ?? date('Y-m-d');
        // dd($tanggal_awal, $tanggal_akhir);
        $kegiatans = Kegiatan::where('user_id', $request->user)
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->get();
        if ($kegiatans->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $pdf = PDF::loadview('kegiatan.cetak', [
            'kegiatans' => $kegiatans
        ]);
        return $pdf->stream();
    }
}
