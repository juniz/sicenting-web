<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'balita_id',
        'tgl_pengukuran',
        'berat',
        'tinggi',
        'lila',
        'usia',
        'bb_u',
        'tb_u',
        'bb_tb',
        'zs_bbu',
        'zs_tbu',
        'zs_bbtb',
     ];

     protected $table = 'pemeriksaan';
}
