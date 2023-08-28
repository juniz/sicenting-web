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
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BalitaImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($index == 0) {
                continue;
            }
            $provinsi = Province::where('name', 'like', '%' . trim($row[5]) . '%')->first();
            // $kabupaten = Regency::where('name', 'like', '%' . $row[6] . '%')->first();
            // $kecamatan = District::where('name', 'like', '%' . $row[7] . '%')->first();
            // $desa = Village::where('name', 'like', '%' . $row[8] . '%')->first();
            $tgl1 = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[3])));
            $tgl2 = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[12])));
            $tglLahir = Carbon::parse($tgl1)->floorMonth();
            $tglPeriksa = Carbon::parse($tgl2)->floorMonth();
            $usia = $tglLahir->diffInMonths($tglPeriksa);
            dd($provinsi);
            // $balita = Balita::create([
            //     'user_id' => auth()->user()->id,
            //     'nik' => $row[0],
            //     'nama' => $row[1],
            //     'jns_kelamin' => $row[2],
            //     'tgl_lahir' => $row[3],
            //     'nama_ortu' => $row[4],
            //     'provinsi' => $provinsi->id,
            //     'kabupaten' => $kabupaten->id,
            //     'kecamatan' => $kecamatan->id,
            //     'kelurahan' => $desa->id,
            //     'rt' => $row[9],
            //     'rw' => $row[10],
            //     'alamat' => $row[11],
            // ]);
            // Pemeriksaan::create([
            //     'balita_id' => $balita->id,
            //     'tgl_pengukuran' => $row[12],
            //     'berat' => $row[13],
            //     'tinggi' => $row[14],
            //     'lila' => $row[15],
            //     'usia' => $usia,
            //     'bb_u' => $row[16],
            //     'tb_u' => $row[18],
            //     'bb_tb' => $row[20],
            //     'zs_bbu' => $row[17],
            //     'zs_tbu' => $row[19],
            //     'zs_bbtb' => $row[21],
            // ]);
        }
    }
}
