<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sasaran',
        'target',
        'tahun',
    ];

    protected $casts = [
        'sasaran' => 'integer',
        'target' => 'integer',
        'tahun' => 'integer',
    ];
}
