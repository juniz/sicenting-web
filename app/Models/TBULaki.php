<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBULaki extends Model
{
    use HasFactory;

    protected $fillable = [
        'usia',
        'min3sd',
        'min2sd',
        'min1sd',
        'median',
        'plus1sd',
        'plus2sd',
        'plus3sd',
    ];
    protected $table = 'tbu_laki';
}
