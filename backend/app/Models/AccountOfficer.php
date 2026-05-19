<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountOfficer extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'username',
        'no_hp',
        'wilayah',
        'password'
    ];

    protected $hidden = ['password'];
}