<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\NasabahMultiSheetImport;

use Maatwebsite\Excel\Facades\Excel;

class NasabahController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL NASABAH
    |--------------------------------------------------------------------------
    */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:51200'
        ]);

        try {

            Excel::import(
                new NasabahMultiSheetImport,
                $request->file('file')
            );

            return response()->json([
                'success' => true,
                'message' => 'Import data berhasil'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA NASABAH
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = \App\Models\Nasabah::query();

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */
        if ($request->status) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('rekening_kredit', 'like', '%' . $request->search . '%')
                  ->orWhere('no_anggota', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json(
            $query->latest()->get()
        );
    }
}