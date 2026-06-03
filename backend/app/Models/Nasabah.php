<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $fillable = [

        // IDENTITAS
        'kode',
        'no_anggota',
        'rekening_kredit',
        'kode_nasabah',

        // NASABAH
        'nama',
        'alamat',

        // PINJAMAN
        'lama',
        'tgl_pinjam',
        'tgl_jt',

        // KEUANGAN
        'nominal',
        'sisa_pokok',
        'pokok_bulanan',
        'bunga_bulanan',

        'tunggakan_pokok',
        'hari_tunggakan_pokok',

        'tunggakan_bunga',
        'hari_tunggakan_bunga',

        'denda',
        'total_tunggakan',

        // LAINNYA
        'ke',
        'kk',
        'gd',
        'se',
        'ju',
        'a',

        // AGUNAN
        'ikatan',
        'nilai_agunan',

        // PPAP
        'j',
        'ppap',
        'bg_persen',

        // PROVISI
        'tb',
        'provisi',
        'sisa_provisi',

        // BYAD
        'byad',

        // AO
        'kode_ao',

        // STATUS
        'status',
    ];

    public function laporanKunjungan()
    {
        return $this->hasMany(LaporanKunjungan::class);
    }

}