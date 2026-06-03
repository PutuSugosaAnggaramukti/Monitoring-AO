<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LaporanKunjungan;
use App\Models\JadwalKunjungan;
use Illuminate\Http\Request;

class LaporanKunjunganController extends Controller
{
    public function index(Request $request)
    {
        $laporan = LaporanKunjungan::with('nasabah')
            ->where('user_id', $request->user()->id)
            ->whereNotNull('nama_ktp')
            ->whereNull('nasabah_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Data laporan berhasil diambil',
            'data'    => $laporan
        ]);
    }

    public function indexLama(Request $request)
    {
        $laporan = LaporanKunjungan::with('nasabah')
            ->where('user_id', $request->user()->id)
            ->whereNotNull('nasabah_id')
            ->whereNull('nama_ktp')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Data laporan berhasil diambil',
            'data'    => $laporan
        ]);
    }

    public function showByNasabah(Request $request, $nasabah_id)
    {
        $laporan = LaporanKunjungan::with('nasabah')
            ->where('user_id', $request->user()->id)
            ->where('nasabah_id', $nasabah_id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($laporan->isEmpty()) {
            return response()->json([
                'message' => 'Laporan tidak ditemukan',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'message' => 'Data laporan berhasil diambil',
            'data'    => $laporan
        ]);
    }

    public function showByJadwal(Request $request, $jadwal_id)
    {
        $jadwal = JadwalKunjungan::find($jadwal_id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan', 'data' => null], 404);
        }

        // Nasabah lama 
        if ($jadwal->nasabah_id) {
            $laporan = LaporanKunjungan::with('nasabah')
                ->where('user_id', $request->user()->id)
                ->where('nasabah_id', $jadwal->nasabah_id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'jenis'   => 'lama',
                'message' => 'Data laporan berhasil diambil',
                'data'    => $laporan
            ]);
        }

        // Nasabah baru 
        $laporan = LaporanKunjungan::where('user_id', $request->user()->id)
            ->whereNotNull('nama_ktp')
            ->whereNull('nasabah_id')
            ->orderByRaw('ABS(DATEDIFF(created_at, ?))', [$jadwal->tanggal_kunjungan])
            ->get();

        return response()->json([
            'jenis'   => 'baru',
            'message' => 'Data laporan berhasil diambil',
            'data'    => $laporan
        ]);
    }

    // POST create laporan (nasabah baru)
   public function store(Request $request)
    {
        $request->validate([
            'nama_ktp'        => 'required|string',
            'nama_tanpa_gelar'=> 'required|string',
            'pendidikan'      => 'nullable|string',
            'npwp'            => 'nullable|string',
            'no_ktp'          => 'required|string',
            'nama_pasangan'   => 'nullable|string',
            'alamat'          => 'required|string',
            'pekerjaan'       => 'required|string',
            'gaji'            => 'required|numeric',
            'catatan'         => 'nullable|string', 
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
        }

        $laporan = LaporanKunjungan::create([
            'user_id'          => $request->user()->id,
            'nama_ktp'         => $request->nama_ktp,
            'nama_tanpa_gelar' => $request->nama_tanpa_gelar,
            'pendidikan'       => $request->pendidikan,
            'npwp'             => $request->npwp,
            'no_ktp'           => $request->no_ktp,
            'nama_pasangan'    => $request->nama_pasangan,
            'alamat'           => $request->alamat,
            'pekerjaan'        => $request->pekerjaan,
            'gaji'             => $request->gaji,
            'catatan'          => $request->catatan,  
            'foto'             => $fotoPath
        ]);

        return response()->json([
            'message' => 'Laporan berhasil disimpan',
            'data'    => $laporan
        ], 201);
    }

    // POST create laporan (nasabah lama)
    public function storeLama(Request $request)
    {
        $request->validate([
            'nasabah_id'        => 'required|integer',
            'tanggal_kunjungan' => 'required|date',
            'kunjungan_ke'      => 'required|integer|min:1',
            'catatan'           => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:10240'
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
        }

        $laporan = LaporanKunjungan::create([
            'user_id'           => $request->user()->id,
            'nasabah_id'        => $request->nasabah_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'kunjungan_ke'      => $request->kunjungan_ke,
            'catatan'           => $request->catatan,
            'foto'              => $fotoPath
        ]);

        // UPDATE STATUS JADWAL
        JadwalKunjungan::where('user_id', $request->user()->id)
            ->where('nasabah_id', $request->nasabah_id)
            ->update(['status' => 'Selesai']);

        return response()->json([
            'message' => 'Laporan berhasil disimpan',
            'data'    => $laporan
        ], 201);
    }

    // DELETE laporan
    public function destroy($id)
    {
        $laporan = LaporanKunjungan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        if ($laporan->foto) {
            \Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus']);
    }
}