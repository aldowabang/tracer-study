<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerAnswer extends Model
{
    protected $fillable = [
        'tracer_period_id',
        'user_id',
        'tracer_question_id',
        'tracer_option_id',
        'jawaban_text',
    ];

    public function tracerPeriod()
    {
        return $this->belongsTo(TracerPeriod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracerQuestion()
    {
        return $this->belongsTo(TracerQuestion::class);
    }

    public function tracerOption()
    {
        return $this->belongsTo(TracerOption::class);
    }
}
