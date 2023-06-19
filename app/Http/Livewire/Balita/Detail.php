<?php

namespace App\Http\Livewire\Balita;

use Livewire\Component;
use App\Models\Balita;
use App\Models\Pemeriksaan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Traits\SwalResponse;

class Detail extends Component
{
    use SwalResponse;
    public $balita, $umur, $hasil, $spAnak, $gizi, $catatanKonsul;
    public function render()
    {
        return view('livewire.balita.detail');
    }

    public function mount($balita)
    {
        $this->balita = $balita;
        $this->hitungUmur();
        $this->hasil = $this->getHasilTerakhir();
        $this->spAnak = DB::table('spesialis')->where('jns', 'Spesialis')->get(); 
        $this->gizi = DB::table('spesialis')->where('jns', 'Gizi')->get();
    }

    public function hydrate()
    {
        $this->spAnak = DB::table('spesialis')->where('jns', 'Spesialis')->get(); 
        $this->gizi = DB::table('spesialis')->where('jns', 'Gizi')->get();
    }

    public function kirimCatatanKonsul()
    {
        try{
            DB::beginTransaction();
            $this->validate([
                'catatanKonsul' => 'required'
            ]);
            DB::table('konsul')->insert([
                'balita_id' => $this->balita->id,
                'catatan' => $this->catatanKonsul
            ]);
            DB::commit();
            $this->reset('catatanKonsul');
            $this->dispatchBrowserEvent('swal:toast', $this->toastResponse('Catatan konsul berhasil disimpan'));
            // $this->alert('success', 'Catatan konsultasi berhasil dikirim');
        }catch(\Exception $e){
            DB::rollback();
            $this->dispatchBrowserEvent('swal:toast', $this->toastResponse($e->getMessage() ?? 'Catatan konsul gagal disimpan', 'error'));
        }
    }

    public function sendWAMessage()
    {
        $response = Http::get('https://api.whatsapp.com/send', [
            'phone' => '628994750136',
            'text' => 'Halo, saya ingin konsultasi tentang balita saya'
        ]);
    }

    public function hitungUmur()
    {
        $tglLahir = $this->balita->tgl_lahir;
        $tglSekarang = date('Y-m-d');
        $diff = date_diff(date_create($tglLahir), date_create($tglSekarang));
        $this->umur = $diff->format('%y Tahun %m Bulan %d Hari');
    }

    public function getHasilTerakhir()
    {
        return Pemeriksaan::where('balita_id', $this->balita->id)->orderBy('created_at', 'desc')->first();
    }

    public function hasilBBU($bbu)
    {
        if(Str::contains($bbu, 'kurang', true)){
            return 'Konsul ahli gizi';
        }
        return 'Normal';
    }

    public function hasilTBU($tbu)
    {
        if(Str::contains($tbu, 'pendek', true)){
            return 'Konsul dokter spesialis anak';
        }
        return 'Normal';
    }

    public function hasilBBTB($bbtb)
    {
        if(Str::contains($bbtb, 'buruk', true) || Str::contains($bbtb, 'kurang', true)){
            return 'Pemberian makanan tambahan (PMT)';
        }
        return 'Normal';
    }
}
