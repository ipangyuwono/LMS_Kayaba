<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Material extends Model
{
    use LogsActivity;
    protected $fillable = [
        'service_id',
        'title',
        'description',
        'type',
        'file_path',
        'url',
        'position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function progress()
    {
        return $this->hasMany(CustomerProgress::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'is_active'])
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Materi baru ditambahkan',
                'updated' => 'Materi diperbarui',
                'deleted' => 'Materi dihapus',
                default   => $eventName,
            })
            ->logOnlyDirty();
    }
}
