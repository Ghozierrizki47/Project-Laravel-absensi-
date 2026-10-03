<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Total kegiatan/presence yang sudah dibuat
        $totalKegiatan = Presence::count();

        // Total peserta yang sudah absen (dari presence_details)
        $totalPeserta = PresenceDetail::count();

        // Kegiatan hari ini
        $kegiatanHariIni = Presence::whereDate('tgl_kegiatan', today())->count();

        // Peserta yang hadir hari ini
        $pesertaHariIni = PresenceDetail::whereHas('presence', function($query) {
            $query->whereDate('tgl_kegiatan', today());
        })->count();

        // Recent activities - ambil 5 presence detail terbaru dengan info presence-nya
        // PENTING: Pastikan data yang diambil adalah data yang masih ada (tidak dihapus)
        $recentActivities = PresenceDetail::with('presence')
            ->latest('created_at')  // Urutkan berdasarkan waktu terbaru
            ->take(5)
            ->get()
            ->map(function($detail) {
                return [
                    'id' => $detail->id,  // Tambahkan ID untuk debugging
                    'nama' => $detail->nama,
                    'jabatan' => $detail->jabatan,
                    'nama_kegiatan' => $detail->presence->nama_kegiatan ?? '-',
                    'waktu_masuk' => $detail->created_at->format('H:i'),
                    'tanggal' => $detail->created_at->format('d/m/Y'),
                ];
            });

        // Ambil kegiatan terbaru untuk link absensi
        $latestPresence = Presence::latest()->first();

        return view('home', compact(
            'totalKegiatan',
            'totalPeserta',
            'kegiatanHariIni',
            'pesertaHariIni',
            'recentActivities',
            'latestPresence'
        ));
    }
}
