<?php

namespace App\Imports;

use App\Models\Balita;
use App\Models\Pemeriksaan;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportBalita implements ToModel
{
    public function model(array $row)
    {
        return new Balita([
            'nama' => $row[0],
            'jenis_kelamin' => $row[1],
            'tanggal_lahir' => $row[2],
            'nama_ibu' => $row[3],
            'nama_ayah' => $row[4],
            'alamat' => $row[5],
            'no_hp' => $row[6],
            'status' => $row[7],
            'user_id' => $row[8],
        ]);
    }
}
