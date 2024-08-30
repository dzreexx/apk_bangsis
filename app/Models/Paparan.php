<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paparan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tanggal',
        'dokumen_paparan'
    ];

    protected $guarded = [
        'id'
    ];
}
