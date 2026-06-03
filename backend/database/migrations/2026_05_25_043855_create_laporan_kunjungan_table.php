<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_kunjungan', function (Blueprint $table) {

            $table->id();

            /*
            |------------------------------------------------------------------
            | RELASI
            |------------------------------------------------------------------
            */

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('nasabah_id')->nullable();

            /*
            |------------------------------------------------------------------
            | KUNJUNGAN
            |------------------------------------------------------------------
            */

            $table->date('tanggal_kunjungan')->nullable();
            $table->integer('kunjungan_ke')->nullable();

            $table->text('catatan')->nullable();

            /*
            |------------------------------------------------------------------
            | NASABAH BARU
            |------------------------------------------------------------------
            */

            $table->string('nama_ktp')->nullable();
            $table->string('nama_tanpa_gelar')->nullable();

            $table->string('pendidikan')->nullable();
            $table->string('npwp')->nullable();

            $table->string('no_ktp')->nullable();

            $table->string('nama_pasangan')->nullable();

            $table->text('alamat')->nullable();

            $table->string('pekerjaan')->nullable();

            $table->bigInteger('gaji')->nullable();

            /*
            |------------------------------------------------------------------
            | FOTO
            |------------------------------------------------------------------
            */

            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_kunjungan');
    }
};