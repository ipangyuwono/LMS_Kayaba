<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Quiz extends Model
{
    use LogsActivity;
    protected $fillable = [
        'service_id',
        'title',
        'description',
        'duration_minutes',
        'passing_score',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('position');
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'is_active'])
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'Quiz baru dibuat',
                'updated' => 'Quiz diperbarui',
                'deleted' => 'Quiz dihapus',
                default   => $eventName,
            })
            ->logOnlyDirty();
    }
}
