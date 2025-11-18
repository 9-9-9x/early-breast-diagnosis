<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BreastResult extends Model
{
    protected $fillable = [
        'breast_exam_id',
        'user_id',
        'prediction',
        'sadari_bulanan',
        'periksa_tahunan',
        'mammografi_40_plus',
        'rujuk_lanjutan',
    ];
    protected $casts = [
        'sadari_bulanan' => 'boolean',
        'periksa_tahunan' => 'boolean',
        'mammografi_40_plus' => 'boolean',
        'rujuk_lanjutan' => 'boolean',
    ];

    public function breastExam()
    {
        return $this->belongsTo(BreastExam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isRecommendationChecked(string $key): bool
    {
        return (bool) $this->getAttribute($key);
    }
}
