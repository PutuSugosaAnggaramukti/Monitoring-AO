<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKunjungan extends Model
{   
    protected $table = 'jadwal_kunjungan';
    protected $fillable = ['user_id', 'nasabah_id', 'tanggal_kunjungan', 'status'];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
