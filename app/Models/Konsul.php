<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsul extends Model
{
    use HasFactory;

    protected $table = 'konsul';

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }
}
