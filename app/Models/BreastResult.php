<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BreastResult extends Model
{
    protected $fillable = [
        'breast_exam_id',
        'user_id',
        'prediction',
    ];

    public function breastExam()
    {
        return $this->belongsTo(BreastExam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
