<?php

namespace App\Models;

use Carbon\Carbon;
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
        'tanggal_lahir',
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

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the calculated age from tanggal_lahir.
     */
    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return Carbon::parse($this->tanggal_lahir)->diffInYears(now());
        }
        return null;
    }

    /**
     * @return BelongsTo<User,PatientProfile>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
