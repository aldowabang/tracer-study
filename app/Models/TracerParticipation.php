<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerParticipation extends Model
{
    protected $fillable = [
        'tracer_period_id',
        'user_id',
        'status',
    ];

    public function tracerPeriod(): BelongsTo
    {
        return $this->belongsTo(TracerPeriod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
