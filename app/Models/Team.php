<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'unit_id', 'jenis', 'telp'];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
