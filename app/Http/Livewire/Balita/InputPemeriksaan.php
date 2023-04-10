<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Pemeriksaan;
use App\Models\Balita;
use App\Models\BBULaki;
use App\Models\BBUPerempuan;
use App\Models\TBULaki;
use App\Models\TBUPerempuan;
use App\Models\BBTBLaki;
use App\Models\BBTBPerempuan;
use App\Traits\SwalResponse;
use Illuminate\Support\Carbon;

class InputPemeriksaan extends Component
{
    use SwalResponse;
    public $tinggi, $berat, $lila, $tanggal, $idBalita, $balita, $umur, $bbu, $tbu, $bbtb, $umurLengkap, $zsBBU, $zsTBU, $zsBBTB;

    public function mount($balita)
    {
        $this->tanggal = Carbon::now()->format('Y-m-d');
        $this->balita = $balita;
    }

    public function render()
    {
        return view('livewire.balita.input-pemeriksaan');
    }

    public function hitungUmur()
    {
        $tglLahir = Carbon::parse($this->balita->tgl_lahir)->floorMonth();
        $tglPeriksa = Carbon::parse($this->tanggal)->floorMonth();
        $this->umur = $tglLahir->diffInMonths($tglPeriksa);
        $this->umurLengkap = $tglLahir->diffForHumans($tglPeriksa, true);
    }

    public function hitungBBU()
    {
        if($this->balita->jns_kelamin == 'L'){
            $data = BBULaki::where('usia', $this->umur)->first();
        }else{
            $data = BBUPerempuan::where('usia', $this->umur)->first();
        }
        if($data){
            if($this->berat > $data->plus1sd){
                $this->bbu = 'Berat badan lebih';
            }else if($this->berat <= $data->min3sd){
                $this->bbu = 'Berat badan sangat kurang';
            }else if($this->berat > $data->min3sd && $this->berat <= $data->min2sd){
                $this->bbu = 'Berat badan kurang';
            }else if($this->berat > $data->min2sd && $this->berat <= $data->min1sd){
                $this->bbu = 'Berat badan normal';
            }else{
                $this->bbu = 'Berat badan normal';
            }
        }
        if($this->berat < $data->median){
            $this->zsBBU = round(($this->berat - $data->median) / ($data->median - $data->min1sd), 2);
        }else if($this->berat > $data->median){
            $this->zsBBU = round(($this->berat - $data->median) / ($data->plus1sd - $data->median), 2);
        }else{
            $this->zsBBU = 0;
        }
        // dd($this->zsBBU);
    }

    public function hitungTBU()
    {
        if($this->balita->jns_kelamin == 'L'){
            $data = TBULaki::where('usia', $this->umur)->first();
        }else{
            $data = TBUPerempuan::where('usia', $this->umur)->first();
        }
        if($data){
            if($this->tinggi > $data->plus3sd){
                $this->tbu = 'Tinggi';
            }else if($this->tinggi > $data->min2sd && $this->tinggi <= $data->plus3sd){
                $this->tbu = 'Tinggi badan normal';
            }else if($this->tinggi > $data->min3sd && $this->tinggi <= $data->min2sd){
                $this->tbu = 'Pendek';
            }else if($this->tinggi <= $data->min3sd){
                $this->tbu = 'Sangat pendek';
            }else{
                $this->tbu = 'Tinggi badan normal';
            }
        }
        if($this->tinggi < $data->median){
            $this->zsTBU = round(($this->tinggi - $data->median) / ($data->median - $data->min1sd), 2);
        }else if($this->tinggi > $data->median){
            $this->zsTBU = round(($this->tinggi - $data->median) / ($data->plus1sd - $data->median), 2);
        }else{
            $this->zsTBU = 0;
        }
        // dd($this->zsTBU);
    }

    public function TBBB()
    {
        if($this->balita->jns_kelamin == 'L'){
            $data = BBTBLaki::where('tb', round($this->tinggi))->first();
        }else{ 
            $data = BBTBPerempuan::where('tb', round($this->tinggi))->first();
        }
        if($data){
            if($this->berat <= $data->min3sd){ 
                $this->bbtb = 'Gizi buruk';
            }else if($this->berat > $data->plus3sd){
                $this->bbtb = 'Obesitas';
            }else if($this->berat > $data->min3sd && $this->berat <= $data->min2sd){
                $this->bbtb = 'Gizi kurang';
            }else if($this->berat > $data->min2sd && $this->berat <= $data->plus1sd){
                $this->bbtb = 'Gizi baik';
            }else if($this->tinggi > $data->plus1sd && $this->tinggi <= $data->plus2sd){
                $this->bbtb = 'Resiko gizi lebih';
            }else if($this->tinggi > $data->plus2sd && $this->tinggi <= $data->plus3sd){
                $this->bbtb = 'Gizi lebih';
            }else{
                $this->bbtb = 'Gizi normal';
            }
        }
        if($this->berat < $data->median){
            $this->zsBBTB = round(($this->berat - $data->median) / ($data->median - $data->min1sd), 2);
        }else if($this->berat > $data->median){
            $this->zsBBTB = round(($this->berat - $data->median) / ($data->plus1sd - $data->median), 2);
        }else{
            $this->zsBBTB = 0;
        }
    }

    public function simpan()
    {
        $this->validate([
            'tinggi' => 'required',
            'berat' => 'required',
            'lila'  =>  'required',
        ],[
            'tinggi.required' => 'Tinggi badan tidak boleh kosong',
            'berat.required' => 'Berat badan tidak boleh kosong',
            'lila.required' => 'Lingkar lengan tidak boleh kosong',
        ]);

        try{
            $this->hitungUmur();
            $this->hitungBBU();
            $this->hitungTBU();
            $this->TBBB();

            $cek = Pemeriksaan::where('balita_id', $this->balita->id)->where('tgl_pengukuran', $this->tanggal)->first();
            if($cek){
                $cek->update([
                    'tgl_pengukuran' => $this->tanggal,
                    'tinggi' => $this->tinggi,
                    'berat' => $this->berat,
                    'lila'  =>  $this->lila,
                    'bb_u' => $this->bbu,
                    'tb_u' => $this->tbu,
                    'bb_tb' => $this->bbtb,
                    'usia' => $this->umur,
                    'zs_bbu' => $this->zsBBU,
                    'zs_tbu' => $this->zsTBU,
                    'zs_bbtb'=> $this->zsBBTB,
                ]);
                // $this->emit('refresh');
                // $this->dispatchBrowserEvent('swal:balita', $this->toastResponse('Data berhasil diubah', 'success'));
                return redirect()->to('/balita/'.$this->balita->id);
            }else{
                Pemeriksaan::create([
                    'tgl_pengukuran' => $this->tanggal,
                    'tinggi' => $this->tinggi,
                    'berat' => $this->berat,
                    'lila'  =>  $this->lila,
                    'balita_id' => $this->balita->id,
                    'bb_u' => $this->bbu,
                    'tb_u' => $this->tbu,
                    'bb_tb' => $this->bbtb,
                    'usia' => $this->umur,
                    'zs_bbu' => $this->zsBBU,
                    'zs_tbu' => $this->zsTBU,
                    'zs_bbtb'=> $this->zsBBTB,
                ]);
                // $this->emit('refresh');
                // $this->dispatchBrowserEvent('swal:balita', $this->toastResponse('Data berhasil disimpan', 'success'));
                return redirect()->to('/balita/'.$this->balita->id);
            }

        }catch(\Exception $e){
            $this->dispatchBrowserEvent('swal:balita', $this->toastResponse($e->getMessage(), 'error'));
        }
    }
}
