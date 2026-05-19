<?php

namespace App\Imports;

use App\Models\Nasabah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class NasabahPerSheetImport implements ToCollection, WithChunkReading
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // Skip header
            if ($index == 0) {
                continue;
            }

            // Skip jika rekening kosong
            if (empty($row[3])) {
                continue;
            }

            Nasabah::create([

                // IDENTITAS
                'kode' => trim($row[1] ?? ''),
                'no_anggota' => trim($row[2] ?? ''),
                'rekening_kredit' => trim($row[3] ?? ''),
                'kode_nasabah' => trim($row[4] ?? ''),

                // DATA NASABAH
                'nama' => trim($row[5] ?? ''),
                'alamat' => trim($row[6] ?? ''),

                // PINJAMAN
                'lama' => (int) ($row[7] ?? 0),

                'tgl_pinjam' =>
                    $this->convertDate($row[8] ?? null),

                'tgl_jt' =>
                    $this->convertDate($row[9] ?? null),

                // KEUANGAN
                'nominal' =>
                    $this->cleanNumber($row[10] ?? 0),

                'sisa_pokok' =>
                    $this->cleanNumber($row[11] ?? 0),

                'pokok_bulanan' =>
                    $this->cleanNumber($row[12] ?? 0),

                'bunga_bulanan' =>
                    $this->cleanNumber($row[13] ?? 0),

                'tunggakan_pokok' =>
                    $this->cleanNumber($row[14] ?? 0),

                'hari_tunggakan_pokok' =>
                    (int) ($row[15] ?? 0),

                'tunggakan_bunga' =>
                    $this->cleanNumber($row[16] ?? 0),

                'hari_tunggakan_bunga' =>
                    (int) ($row[17] ?? 0),

                'denda' =>
                    $this->cleanNumber($row[18] ?? 0),

                'total_tunggakan' =>
                    $this->cleanNumber($row[19] ?? 0),

                // LAINNYA
                'ke' => $row[20] ?? null,
                'kk' => $row[21] ?? null,
                'gd' => $row[22] ?? null,
                'se' => $row[23] ?? null,
                'ju' => $row[24] ?? null,
                'a' => $row[25] ?? null,

                'ikatan' => $row[26] ?? null,

                'nilai_agunan' =>
                    $this->cleanNumber($row[27] ?? 0),

                'j' => $row[28] ?? null,

                'ppap' =>
                    $this->cleanNumber($row[29] ?? 0),

                'bg_persen' =>
                    $this->cleanNumber($row[30] ?? 0),

                'tb' => $row[31] ?? null,

                'provisi' =>
                    $this->cleanNumber($row[32] ?? 0),

                'sisa_provisi' =>
                    $this->cleanNumber($row[33] ?? 0),

                'byad' =>
                    $this->cleanNumber($row[34] ?? 0),

                'kode_ao' => $row[35] ?? null,

                // STATUS
                'status' => $this->status,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAN NUMBER
    |--------------------------------------------------------------------------
    | Menghapus titik, koma, dll
    */
   private function cleanNumber($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $clean = preg_replace('/[^0-9]/', '', (string) $value);

        return (float) $clean;
    }

    /*
    |--------------------------------------------------------------------------
    | CONVERT DATE EXCEL
    |--------------------------------------------------------------------------
    */
    private function convertDate($value)
    {
        try {

            if (!$value) {
                return null;
            }

            // Jika format numeric excel
            if (is_numeric($value)) {

                return Carbon::instance(
                    Date::excelToDateTimeObject($value)
                )->format('Y-m-d');
            }

            // Jika format string tanggal biasa
            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Exception $e) {

            return null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CHUNK IMPORT
    |--------------------------------------------------------------------------
    */
    public function chunkSize(): int
    {
        return 500;
    }
}