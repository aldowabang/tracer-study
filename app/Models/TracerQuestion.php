<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerQuestion extends Model
{
    protected $fillable = [
        'tracer_period_id',
        'kode_dikti',
        'pertanyaan',
        'tipe',
        'urutan',
        'wajib_diisi',
    ];

    public function tracerPeriod()
    {
        return $this->belongsTo(TracerPeriod::class);
    }

    public function tracerOptions()
    {
        return $this->hasMany(TracerOption::class);
    }

    public function tracerAnswers()
    {
        return $this->hasMany(TracerAnswer::class);
    }
}
