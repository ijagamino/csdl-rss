<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'report_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
