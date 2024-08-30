<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapkonis extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'tanggal',
        'klasifikasi',
        'lokasi',
        'kondisi',
        'alamat',
        'satker',
        'upload'
    ];
    protected $guarded = [
        'id'
    ];
}
