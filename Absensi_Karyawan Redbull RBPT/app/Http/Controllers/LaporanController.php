<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = Laporan::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Laporan::count(),
            'pending' => Laporan::where('status', 'pending')->count(),
            'disetujui' => Laporan::where('status', 'disetujui')->count(),
            'ditolak' => Laporan::where('status', 'ditolak')->count(),
            'sakit' => Laporan::where('jenis_laporan', 'sakit')->count(),
            'izin' => Laporan::where('jenis_laporan', 'izin')->count(),
            'cuti' => Laporan::where('jenis_laporan', 'cuti')->count(),
        ];

        return view('pages.laporan.index', compact('laporans', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jenis_laporan' => 'required|in:sakit,izin,cuti,dinas_luar,lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // Upload file jika ada
        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('laporan', $filename, 'public');
            $validated['file_pendukung'] = $path;
        }

        Laporan::create($validated);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        return view('pages.laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        return view('pages.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'jenis_laporan' => 'required|in:sakit,izin,cuti,dinas_luar,lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:pending,disetujui,ditolak',
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('file_pendukung')) {
            // Hapus file lama jika ada
            if ($laporan->file_pendukung) {
                Storage::disk('public')->delete($laporan->file_pendukung);
            }

            $file = $request->file('file_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('laporan', $filename, 'public');
            $validated['file_pendukung'] = $path;
        }

        $laporan->update($validated);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Update status laporan
     */
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $laporan->update([
            'status' => $request->status
        ]);

        return redirect()->back()
            ->with('success', 'Status laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        // Hapus file jika ada
        if ($laporan->file_pendukung) {
            Storage::disk('public')->delete($laporan->file_pendukung);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}
