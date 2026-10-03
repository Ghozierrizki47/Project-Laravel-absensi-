<?php

namespace App\Http\Controllers;

use App\DataTables\PresenceDetailsDataTable;
use App\DataTables\PresencesDataTable;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresenceController extends Controller
{
    // TAMPILKAN DAFTAR KEGIATAN / DAFTAR KEHADIRAN
    public function index(PresencesDataTable $dataTable)
    {
        return $dataTable->render('pages.presence.index');
    }

    // FORM BUAT KEGIATAN / DAFTAR KEHADIRAN BARU
    public function create()
    {
        return view('pages.presence.create');
    }

    // SIMPAN KEGIATAN BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tgl_kegiatan'  => 'required|date',
            'waktu_mulai'   => 'required', // time / string
        ]);

        $tglKegiatan = $request->tgl_kegiatan . ' ' . $request->waktu_mulai;

        Presence::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'slug'          => Str::slug($request->nama_kegiatan . '-' . now()->format('YmdHis')),
            'tgl_kegiatan'  => $tglKegiatan,
        ]);

        return redirect()
            ->route('presence.index')
            ->with('success', 'Daftar kehadiran berhasil dibuat.');
    }

    // TAMPILKAN DETAIL ABSEN UNTUK SATU KEGIATAN
    public function show(string $id, PresenceDetailsDataTable $dataTable)
    {
        $presence = Presence::findOrFail($id);

        return $dataTable->render('pages.presence.detail.index', compact('presence'));
    }

    // FORM EDIT KEGIATAN
    public function edit(string $id)
    {
        $presence = Presence::findOrFail($id);
        return view('pages.presence.edit', compact('presence'));
    }

    // UPDATE KEGIATAN
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tgl_kegiatan'  => 'required|date',
            'waktu_mulai'   => 'required',
        ]);

        $presence = Presence::findOrFail($id);
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug          = Str::slug($request->nama_kegiatan . '-' . now()->format('YmdHis'));
        $presence->tgl_kegiatan  = $request->tgl_kegiatan . ' ' . $request->waktu_mulai;
        $presence->save();

        return redirect()
            ->route('presence.index')
            ->with('success', 'Daftar kehadiran berhasil diperbarui.');
    }

    // HAPUS KEGIATAN + DETAIL ABSEN
    public function destroy(string $id)
    {
        $presenceDetails = PresenceDetail::where('presence_id', $id)->get();

        foreach ($presenceDetails as $pd) {
            if ($pd->tanda_tangan) {
                Storage::disk('public')->delete($pd->tanda_tangan);
            }
            // face_photo sudah tidak ada, jadi tidak perlu dihapus
            $pd->delete();
        }

        Presence::destroy($id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dihapus',
        ]);
    }

    // SIMPAN ABSENSI PESERTA (HANYA TANDA TANGAN)
    public function absenSave(Request $request, $id)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'jabatan'        => 'required|string|max:255',
            'asal_instansi'  => 'required|string|max:255',
            'signature'      => 'required',
            // 'face_photo' DIHAPUS
        ]);

        try {
            // Simpan signature (tanda tangan)
            $signatureBase64 = $request->signature;
            $signatureBase64 = str_replace('data:image/png;base64,', '', $signatureBase64);
            $signatureBase64 = str_replace(' ', '+', $signatureBase64);
            $sig = base64_decode($signatureBase64);
            $sigFilename = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $sigFilename, $sig);

            // TIDAK ADA LAGI PENGOLAHAN FACE PHOTO

            PresenceDetail::create([
                'presence_id'   => $id,
                'nama'          => $request->nama,
                'jabatan'       => $request->jabatan,
                'asal_instansi' => $request->asal_instansi,
                'tanda_tangan'  => 'signatures/' . $sigFilename,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Absensi berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
