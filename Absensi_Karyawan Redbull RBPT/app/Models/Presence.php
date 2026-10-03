<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'slug',
        'tgl_kegiatan',
    ];

    // Kalau tgl_kegiatan bertipe DATE/DATETIME
    protected $dates = ['tgl_kegiatan'];

    // Relasi ke detail absen
    public function details()
    {
        return $this->hasMany(PresenceDetail::class);
    }

    // (Opsional) kalau kamu pakai slug di URL
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Auto-generate slug kalau belum diisi
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($presence) {
            if (empty($presence->slug)) {
                $presence->slug = Str::slug(
                    $presence->nama_kegiatan . '-' . now()->format('YmdHis')
                );
            }
        });
    }
}
