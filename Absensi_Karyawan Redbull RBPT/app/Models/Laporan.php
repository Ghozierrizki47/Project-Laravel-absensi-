<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_karyawan',
        'jenis_laporan',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'file_pendukung',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method untuk label jenis laporan
    public static function getJenisLaporanLabels()
    {
        return [
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'cuti' => 'Cuti',
            'dinas_luar' => 'Dinas Luar',
            'lainnya' => 'Lainnya',
        ];
    }

    // Helper method untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'disetujui' => '<span class="badge bg-success">Disetujui</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
        ];

        return $badges[$this->status] ?? '';
    }

    // Helper method untuk durasi hari
    public function getDurasiHariAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }
}
