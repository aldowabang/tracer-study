<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerPeriod extends Model
{
    protected $fillable = [
        'tahun_lulusan',
        'judul',
        'tgl_mulai',
        'tgl_selesai',
        'is_active',
    ];

    public function tracerQuestions()
    {
        return $this->hasMany(TracerQuestion::class);
    }

    public function tracerAnswers()
    {
        return $this->hasMany(TracerAnswer::class);
    }
}
