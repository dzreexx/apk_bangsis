<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'name',
        'nrp',
        'pangkat',
        'korp',
        'role',
        'password',
    ];

    protected $guarded = [
        'id',
        'post_id'
    ];
}
