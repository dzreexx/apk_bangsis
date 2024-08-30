<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nodin extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'judul',
        'tanggal',
        'konseptor',
        'keterangan',
        'dokumen_nodin'
    ];

    protected $guarded = [
        'id'
    ];
}
