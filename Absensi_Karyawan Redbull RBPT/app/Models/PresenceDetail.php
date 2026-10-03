<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'presence_id',
        'nama',
        'jabatan',
        'asal_instansi',
        'tanda_tangan',
        // 'face_photo' DIHAPUS
    ];

    public function presence()
    {
        return $this->belongsTo(Presence::class);
    }
}
