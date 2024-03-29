<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';
    protected $fillable = ['nama', 'provinsi_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
