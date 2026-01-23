<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'nama',
        'umur',
        'suku_bangsa',
        'agama',
        'bb',
        'tb',
        'jumlah_anak_kandung',
        'nomor_telepon',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'pendidikan_terakhir',
        'pekerjaan_pasien',
        'pekerjaan_suami',
        'perkawinan_pasangan',
    ];

    /**
     * @return BelongsTo<User,PatientProfile>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
