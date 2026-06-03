<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKunjungan;

class JadwalKunjunganController extends Controller
{
    public function index(Request $request)
    {
        $jadwal = JadwalKunjungan::with('nasabah')
            ->where('user_id', $request->user()->id)
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();

        return response()->json(['data' => $jadwal]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id'        => 'required|integer',
            'tanggal_kunjungan' => 'required|date'
        ]);

        $jadwal = JadwalKunjungan::create([
            'user_id'           => $request->user()->id,
            'nasabah_id'        => $request->nasabah_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status'            => 'Belum Dikunjungi'
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil dibuat',
            'data'    => $jadwal
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKunjungan::find($id);
        if (!$jadwal) return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);

        $jadwal->update(['status' => $request->status]);

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $jadwal = JadwalKunjungan::find($id);
        if (!$jadwal) return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }

    public function dropdownNasabah(Request $request)
    {
        $data = JadwalKunjungan::with('nasabah')
            ->where('user_id', $request->user()->id)
            ->where('status', 'Belum Dikunjungi')
            ->get()
            ->map(function ($item) {

                return [
                    'id'               => $item->nasabah->id,
                    'no_anggota'       => $item->nasabah->no_anggota,
                    'rekening_kredit'  => $item->nasabah->rekening_kredit,
                    'nama'             => $item->nasabah->nama,
                    'alamat'           => $item->nasabah->alamat,
                    'tanggal'          => $item->tanggal_kunjungan,
                ];
            });

        return response()->json($data);
    }
}
