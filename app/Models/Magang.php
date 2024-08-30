<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nim',
        'univ',
        'dateStart',
        'dateEnd',
        'judul',
        'laporan',
    ];
    protected $guarded = [
        'id',
    ];
}
