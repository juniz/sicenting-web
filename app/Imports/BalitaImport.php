<?php

namespace App\Imports;

use App\Models\Balita;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Pemeriksaan;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BalitaImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $tgl1 = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[3])));
        $tgl2 = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[12])));
        $tglLahir = Carbon::parse($tgl1)->floorMonth();
        $tglPeriksa = Carbon::parse($tgl2)->floorMonth();
        $usia = $tglLahir->diffInMonths($tglPeriksa);
        $balita = Balita::create([
            'user_id' => 'd6ee74d9-8adc-42c1-a0bb-d70f755984ae',
            'nik' => intval($row[0]),
            'nama' => $row[1],
            'jns_kelamin' => $row[2],
            'tgl_lahir' => $tgl1->format('Y-m-d'),
            'nama_ortu' => $row[4] ?? '-',
            'provinsi' => "76",
            'kabupaten' => "7602",
            'kecamatan' => $row[7],
            'kelurahan' => $row[8],
            'rt' => $row[9],
            'rw' => $row[10],
            'alamat' => $row[11],
        ]);
        Pemeriksaan::create([
            'balita_id' => $balita->id,
            'tgl_pengukuran' => $tgl2->format('Y-m-d'),
            'berat' => $row[13] ?? '',
            'tinggi' => $row[14] ?? '',
            'lila' => $row[15],
            'usia' => $usia,
            'bb_u' => $row[16] ?? '',
            'tb_u' => $row[18] ?? '',
            'bb_tb' => $row[20] ?? '',
            'zs_bbu' => $row[17] ?? '',
            'zs_tbu' => $row[19] ?? '',
            'zs_bbtb' => $row[21] ?? '',
        ]);
        // foreach ($rows as $index => $row) {
        //     if ($index == 0) {
        //         continue;
        //     } else if ($index == 19617) {
        //         break;
        //     } else {
        //         // $provinsi = Province::where('name', 'like', '%' . trim($row[5]) . '%')->first();
        //         // $kabupaten = Regency::where('name', 'like', '%' . $row[6] . '%')->first();
        //         // $kecamatan = District::where('name', 'like', '%' . $row[7] . '%')->where('regency_id', '7602')->first();
        //         // $desa = Village::where('name', 'like', $row[8] . '%')->where('district_id', $kecamatan->id)->first();
        //         // dd($desa);
        //         $tgl1 = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[3])));
        //         $tgl2 = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[12])));
        //         $tglLahir = Carbon::parse($tgl1)->floorMonth();
        //         $tglPeriksa = Carbon::parse($tgl2)->floorMonth();
        //         $usia = $tglLahir->diffInMonths($tglPeriksa);
        //         $balita = Balita::create([
        //             'user_id' => auth()->user()->id,
        //             'nik' => $row[0],
        //             'nama' => $row[1],
        //             'jns_kelamin' => $row[2],
        //             'tgl_lahir' => $row[3],
        //             'nama_ortu' => $row[4],
        //             'provinsi' => "76",
        //             'kabupaten' => "7602",
        //             'kecamatan' => $row[7],
        //             'kelurahan' => $row[8],
        //             'rt' => $row[9],
        //             'rw' => $row[10],
        //             'alamat' => $row[11],
        //         ]);
        //         Pemeriksaan::create([
        //             'balita_id' => $balita->id,
        //             'tgl_pengukuran' => $row[12],
        //             'berat' => $row[13],
        //             'tinggi' => $row[14],
        //             'lila' => $row[15],
        //             'usia' => $usia,
        //             'bb_u' => $row[16],
        //             'tb_u' => $row[18],
        //             'bb_tb' => $row[20],
        //             'zs_bbu' => $row[17],
        //             'zs_tbu' => $row[19],
        //             'zs_bbtb' => $row[21],
        //         ]);
        //     }
        // }
    }
}
