<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Naskah extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tanggal',
        'dokumen_naskah'
    ];

    protected $guarded = [
        'id'
    ];
}
