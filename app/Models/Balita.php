<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'nik',
        'nama',
        'jns_kelamin',
        'tgl_lahir',
        'nama_ortu',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'alamat',
        'user_id',
    ];

    protected $table = 'balita';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLastPemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class)->latestOfMany();
    }

    public function konsul()
    {
        return $this->hasOne(Konsul::class)->latestOfMany();
    }
}
