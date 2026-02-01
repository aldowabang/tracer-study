<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerOption extends Model
{
    protected $fillable = [
        'tracer_question_id',
        'label',
        'value',
        'urutan',
        'is_active',
    ];

    public function tracerQuestion()
    {
        return $this->belongsTo(TracerQuestion::class);
    }
}
