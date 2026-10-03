<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresenceDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exportPdf(string $id)
    {
        $presence = Presence::findOrFail($id);
        $presenceDetails = PresenceDetail::where('presence_id', $id)->get();

        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('pages.presence.detail.export-pdf', compact('presence', 'presenceDetails'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream("{$presence->nama_kegiatan}.pdf", ['Attachment' => 0]);
    }

    public function destroy($id)
    {
        try {
            \Log::info('Delete request received', ['id' => $id, 'type' => gettype($id)]);
            
            // Cari data berdasarkan ID
            $presenceDetail = PresenceDetail::find($id);
            
            if (!$presenceDetail) {
                \Log::error('PresenceDetail not found', ['id' => $id]);
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data tidak ditemukan dengan ID: ' . $id,
                ], 404);
            }

            \Log::info('PresenceDetail found', ['id' => $presenceDetail->id, 'nama' => $presenceDetail->nama]);

            // Hapus file tanda tangan jika ada
            if ($presenceDetail->tanda_tangan) {
                Storage::disk('public')->delete($presenceDetail->tanda_tangan);
                \Log::info('Signature file deleted', ['file' => $presenceDetail->tanda_tangan]);
            }

            // Hapus data dari database
            $presenceDetail->delete();
            
            \Log::info('PresenceDetail deleted successfully', ['id' => $id]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data peserta "' . $presenceDetail->nama . '" berhasil dihapus!',
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Delete failed', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
