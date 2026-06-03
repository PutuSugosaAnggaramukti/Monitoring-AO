<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKunjungan extends Model
{
    protected $table = 'laporan_kunjungan';

    protected $fillable = [
        'user_id','nasabah_id','tanggal_kunjungan','kunjungan_ke','catatan', 'nama_ktp', 'nama_tanpa_gelar', 'pendidikan',
        'npwp', 'no_ktp', 'nama_pasangan', 'alamat',
        'pekerjaan', 'gaji', 'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

}