<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Pemeriksaan;
use App\Models\TBULaki;
use App\Models\TBUPerempuan;
use App\Models\BBULaki;
use App\Models\BBUPerempuan;
use App\Models\BBTBLaki;
use App\Models\BBTBPerempuan;
use App\Traits\SwalResponse;
use Illuminate\Support\Str;

class Riwayat extends Component
{
    use SwalResponse;
    public $balita, $pemeriksaan, $usiaList, $usia, $tb, $tbuMedian, $tbuPlus2Sd, $tbuPlus3Sd, $tbuMin2Sd, $tbuMin3Sd, $tbu, $bbu, $bbtb, $bbuMedian, $bbuPlus2Sd, $bbuPlus3Sd, $bbuMin2Sd, $bbuMin3Sd, $bbtbMedian, $bbtbPlus2Sd, $bbtbPlus3Sd, $bbtbMin2Sd, $bbtbMin3Sd, $bbPemeriksaan, $tbPemeriksaan, $hasil = [];

    protected $listeners = ['refresh' => 'refresh', 'hapusPemeriksaan' => 'hapusPemeriksaan'];
    public function render()
    {
        return view('livewire.balita.riwayat');
    }

    public function mount($balita)
    {
        $this->balita = $balita;
        $this->refresh();
    }

    public function konfirmasiHapus($id)
    {
        $this->dispatchBrowserEvent('swal:confirm', $this->swalConfirmDialog('hapusPemeriksaan', [$id]));
    }

    public function hapusPemeriksaan($id)
    {
        try{

            $data = Pemeriksaan::find($id);
            $data->delete();
            $this->dispatchBrowserEvent('swal:toast', $this->toastResponse('Data berhasil dihapus'));
            $this->refresh();

        }catch(\Exception $e){

            $this->dispatchBrowserEvent('swal:toast', $this->toastResponse($e->getMessage() ?? 'Data gagal dihapus', 'error'));
        }
    }

    public function hasilPemeriksaan($id)
    {
        $hasilBBU = '-';
        $hasilBBTB = '-';
        $hasilTBU = '-';
        try{

            $data = Pemeriksaan::find($id);
            // dd($data);
            if(Str::contains($data->bb_u, 'kurang', true)){
                $hasilBBU = 'Konsul ahli gizi';
            }
            if(Str::contains($data->tb_u, 'pendek', true)){
                $hasilTBU = 'Konsul dokter spesialis anak';
            }
            if(Str::contains($data->bb_tb, 'buruk', true)){
                $hasilBBTB = 'Pemberian PMT';
            }

            $this->hasil =  [
                'hasil_bbu' =>  $hasilBBU,
                'hasil_bbtb' =>  $hasilBBTB,
                'hasil_tbu' =>  $hasilTBU,
                'bbu'   =>  $data->bb_u,
                'bbtb'  =>  $data->bb_tb,
                'tbu'   =>  $data->tb_u,
            ];

            $this->dispatchBrowserEvent('modal:saran', [
                'hasil_bbu' =>  $hasilBBU,
                'hasil_bbtb' =>  $hasilBBTB,
                'hasil_tbu' =>  $hasilTBU,
                'bbu'   =>  $data->bb_u,
                'bbtb'  =>  $data->bb_tb,
                'tbu'   =>  $data->tb_u,
            ]);

        }catch(\Exception $e){
                
                $this->dispatchBrowserEvent('swal:toast', $this->toastResponse($e->getMessage() ?? 'Gagal mendapatkan data', 'error'));
        }
    }

    public function refresh()
    {
        $this->grafikTBU();
        $this->grafikBBU();
        $this->grafikBBTB();
        $data = Pemeriksaan::where('balita_id', $this->balita->id);
        $this->pemeriksaan = $data->get()->toArray();
        $this->bbPemeriksaan = $data->get()->pluck('berat');
        $this->tbPemeriksaan = $data->get()->pluck('tinggi');
        $this->tbu = $data->get()->pluck('tinggi');
        $this->bbu = $data->get()->pluck('berat');
        $this->usiaList = $data->get()->pluck('usia');
        $this->listTB();
    }

    public function listTB()
    {
        if (count($this->usiaList) > 0){
            for($i=0;$i<$this->usiaList[0];$i++){
                $this->tbu->prepend(null);
                $this->bbu->prepend(null);
            }
        }
        $jml = ($this->tbPemeriksaan[0] - 45) * 2;
        for($i=0;$i<$jml;$i++){
            $this->bbPemeriksaan->prepend(null);
        }
    }

    public function grafikTBU()
    {
        if($this->balita->jns_kelamin == 'L'){
            $data = TBULaki::all();
        }else{
            $data = TBUPerempuan::all();
        }
        $this->usia = $data->pluck('usia');
        $this->tbuMedian = $data->pluck('median');
        $this->tbuPlus2Sd = $data->pluck('plus2sd');
        $this->tbuPlus3Sd = $data->pluck('plus3sd');
        $this->tbuMin2Sd = $data->pluck('min2sd');
        $this->tbuMin3Sd = $data->pluck('min3sd');
    }

    public function grafikBBU()
    {
        if($this->balita->jns_kelamin == 'L'){
            $data = BBULaki::all();
        }else{
            $data = BBUPerempuan::all();
        }
        // $this->usia = $data->pluck('usia');
        $this->bbuMedian = $data->pluck('median');
        $this->bbuPlus2Sd = $data->pluck('plus2sd');
        $this->bbuPlus3Sd = $data->pluck('plus3sd');
        $this->bbuMin2Sd = $data->pluck('min2sd');
        $this->bbuMin3Sd = $data->pluck('min3sd');
    }

    public function grafikBBTB()
    {
        if($this->balita->jns_kelamin == 'L'){
            $data = BBTBLaki::all();
        }else{
            $data = BBTBPerempuan::all();
        }
        $this->tb = $data->pluck('tb');
        $this->bbtbMedian = $data->pluck('median');
        $this->bbtbPlus2Sd = $data->pluck('plus2sd');
        $this->bbtbPlus3Sd = $data->pluck('plus3sd');
        $this->bbtbMin2Sd = $data->pluck('min2sd');
        $this->bbtbMin3Sd = $data->pluck('min3sd');
    }
}
