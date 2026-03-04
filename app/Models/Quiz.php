<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
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
}
