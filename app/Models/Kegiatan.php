<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal',
        'personel',
        'kegiatan',
        'bukti',
        // 'buktiDua',
        // 'buktiTiga'
    ];

    protected $guarded = [
        'id',
    ];

}