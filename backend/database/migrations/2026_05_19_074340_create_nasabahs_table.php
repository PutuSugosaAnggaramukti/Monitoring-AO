<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nasabahs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS
            |--------------------------------------------------------------------------
            */

            $table->string('kode')->nullable();
            $table->string('no_anggota')->nullable();
            $table->string('rekening_kredit')->nullable()->index();
            $table->string('kode_nasabah')->nullable();

            /*
            |--------------------------------------------------------------------------
            | DATA NASABAH
            |--------------------------------------------------------------------------
            */

            $table->string('nama')->nullable();
            $table->text('alamat')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PINJAMAN
            |--------------------------------------------------------------------------
            */

            $table->integer('lama')->nullable();

            $table->date('tgl_pinjam')->nullable();
            $table->date('tgl_jt')->nullable();

            /*
            |--------------------------------------------------------------------------
            | KEUANGAN
            |--------------------------------------------------------------------------
            */

            $table->bigInteger('nominal')->nullable();
            $table->bigInteger('sisa_pokok')->nullable();

            $table->bigInteger('pokok_bulanan')->nullable();
            $table->bigInteger('bunga_bulanan')->nullable();

            $table->bigInteger('tunggakan_pokok')->nullable();
            $table->integer('hari_tunggakan_pokok')->nullable();

            $table->bigInteger('tunggakan_bunga')->nullable();
            $table->integer('hari_tunggakan_bunga')->nullable();

            $table->bigInteger('denda')->nullable();
            $table->bigInteger('total_tunggakan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | KOLEKTIBILITAS
            |--------------------------------------------------------------------------
            */

            $table->string('ke')->nullable();
            $table->string('kk')->nullable();
            $table->string('gd')->nullable();
            $table->string('se')->nullable();
            $table->string('ju')->nullable();
            $table->string('a')->nullable();

            /*
            |--------------------------------------------------------------------------
            | AGUNAN
            |--------------------------------------------------------------------------
            */

            $table->string('ikatan')->nullable();

            $table->bigInteger('nilai_agunan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PPAP
            |--------------------------------------------------------------------------
            */

            $table->string('j')->nullable();

            $table->bigInteger('ppap')->nullable();

            $table->decimal('bg_persen', 8, 2)->nullable();

            /*
            |--------------------------------------------------------------------------
            | PROVISI
            |--------------------------------------------------------------------------
            */

            $table->string('tb')->nullable();

            $table->bigInteger('provisi')->nullable();
            $table->bigInteger('sisa_provisi')->nullable();

            /*
            |--------------------------------------------------------------------------
            | BYAD
            |--------------------------------------------------------------------------
            */

            $table->bigInteger('byad')->nullable();

            /*
            |--------------------------------------------------------------------------
            | AO
            |--------------------------------------------------------------------------
            */

            $table->string('kode_ao')->nullable()->index();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->string('status')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabahs');
    }
};