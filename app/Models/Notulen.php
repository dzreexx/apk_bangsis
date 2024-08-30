<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notulen extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tanggal',
        'konseptor',
        'keterangan',
        'dokumen_notulen'
    ];

    protected $guarded = [
        'id'
    ];
}
