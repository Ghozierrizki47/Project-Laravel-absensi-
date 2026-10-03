<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapBulananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request, default bulan dan tahun saat ini
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Query data presence berdasarkan bulan dan tahun
        $dataRekap = Presence::whereYear('tgl_kegiatan', $tahun)
            ->whereMonth('tgl_kegiatan', $bulan)
            ->withCount('details as jumlah_peserta')
            ->orderBy('tgl_kegiatan', 'asc')
            ->get();

        // Hitung statistik
        $totalKegiatan = $dataRekap->count();
        $totalPeserta = $dataRekap->sum('jumlah_peserta');
        $rataRata = $totalKegiatan > 0 ? round($totalPeserta / $totalKegiatan, 1) : 0;
        $kegiatanTerbanyak = $dataRekap->max('jumlah_peserta') ?? 0;

        return view('pages.rekap-bulanan', compact(
            'dataRekap',
            'totalKegiatan',
            'totalPeserta',
            'rataRata',
            'kegiatanTerbanyak',
            'bulan',
            'tahun'
        ));
    }

    public function export(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Query data
        $dataRekap = Presence::whereYear('tgl_kegiatan', $tahun)
            ->whereMonth('tgl_kegiatan', $tahun)
            ->withCount('details as jumlah_peserta')
            ->orderBy('tgl_kegiatan', 'asc')
            ->get();

        // Generate PDF menggunakan DomPDF atau library lainnya
        // TODO: Implementasi PDF export
        
        return response()->json([
            'message' => 'Export PDF akan segera tersedia',
            'data' => $dataRekap
        ]);
    }
}
