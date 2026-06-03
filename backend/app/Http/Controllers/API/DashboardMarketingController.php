<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JadwalKunjungan;
use App\Models\LaporanKunjungan;

class DashboardMarketingController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // TOTAL JADWAL
        $totalJadwal = JadwalKunjungan::where('user_id', $userId)->count();

        // LAPKUN NASABAH BARU
        $lapkunBaru = LaporanKunjungan::where('user_id', $userId)
            ->whereNull('nasabah_id')
            ->count();

        // LAPKUN NASABAH LAMA
        $lapkunLama = LaporanKunjungan::where('user_id', $userId)
            ->whereNotNull('nasabah_id')
            ->count();

        // JADWAL HARI INI
        $jadwalHariIni = JadwalKunjungan::with('nasabah')
            ->where('user_id', $userId)
            ->whereDate('tanggal_kunjungan', now())
            ->latest()
            ->take(5)
            ->get();

        // REMINDER
        $jadwalBelum = JadwalKunjungan::where('user_id', $userId)
            ->where('status', 'Belum Dikunjungi')
            ->count();

        $jadwalSelesai = JadwalKunjungan::where('user_id', $userId)
            ->where('status', 'Selesai')
            ->count();

        // target sementara
        $targetMingguan = 72;

        // AKTIVITAS — gabung jadwal + laporan, ambil 6 terbaru
        $aktivitasJadwal = JadwalKunjungan::with('nasabah')
            ->where('user_id', $userId)
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($item) {
                return [
                    'id'           => 'jadwal_' . $item->id,
                    'jenis'        => 'jadwal',
                    'keterangan'   => 'Buat Jadwal Kunjungan',
                    'nama_nasabah' => $item->nasabah?->nama ?? '-',
                    'label'        => null,
                    'created_at'   => $item->created_at,
                ];
            });

        $aktivitasLaporan = LaporanKunjungan::with('nasabah')
            ->where('user_id', $userId)
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($item) {
                $isNasabahBaru = is_null($item->nasabah_id);
                return [
                    'id'           => 'laporan_' . $item->id,
                    'jenis'        => 'laporan',
                    'keterangan'   => 'Upload Laporan Kunjungan',
                    'nama_nasabah' => $isNasabahBaru
                                        ? ($item->nama_ktp ?? '-')
                                        : ($item->nasabah?->nama ?? '-'),
                    'label'        => $isNasabahBaru ? 'Nasabah Baru' : 'Nasabah Lama',
                    'created_at'   => $item->created_at,
                ];
            });

        // Gabung, sort by created_at desc, ambil 6 teratas
        $aktivitas = $aktivitasJadwal
            ->concat($aktivitasLaporan)
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        return response()->json([
            'statistik' => [
                'jadwal'      => $totalJadwal,
                'lapkun_baru' => $lapkunBaru,
                'lapkun_lama' => $lapkunLama,
            ],

            'reminder' => [
                'jadwal_belum'    => $jadwalBelum,
                'jadwal_selesai'  => $jadwalSelesai,
                'target_mingguan' => $targetMingguan,
            ],

            'jadwal_hari_ini' => $jadwalHariIni,
            'aktivitas'       => $aktivitas,
        ]);
    }
}