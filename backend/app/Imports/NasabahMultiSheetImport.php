<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NasabahMultiSheetImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | SHEET LANCAR
            |--------------------------------------------------------------------------
            */
            'Lancar' =>
                new NasabahPerSheetImport('lancar'),

            /*
            |--------------------------------------------------------------------------
            | SHEET DPK
            |--------------------------------------------------------------------------
            */
            'Dalam Perhatian Khusus' =>
                new NasabahPerSheetImport('dpk'),

            /*
            |--------------------------------------------------------------------------
            | SHEET KURANG LANCAR
            |--------------------------------------------------------------------------
            */
            'Kurang Lancar' =>
                new NasabahPerSheetImport('kurang_lancar'),

            /*
            |--------------------------------------------------------------------------
            | SHEET DIRAGUKAN
            |--------------------------------------------------------------------------
            */
            'Diragukan' =>
                new NasabahPerSheetImport('diragukan'),

            /*
            |--------------------------------------------------------------------------
            | SHEET MACET
            |--------------------------------------------------------------------------
            */
            'Macet' =>
                new NasabahPerSheetImport('macet'),
        ];
    }
}