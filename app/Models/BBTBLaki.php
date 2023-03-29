<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BBTBLaki extends Model
{
    use HasFactory;

    protected $fillable = [
        'tb',
        'min3sd',
        'min2sd',
        'min1sd',
        'median',
        'plus1sd',
        'plus2sd',
        'plus3sd',
    ];
    protected $table = 'bbtb_laki';
}
