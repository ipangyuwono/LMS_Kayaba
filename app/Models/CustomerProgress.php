<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CustomerProgress extends Model
{
    use LogsActivity;
    protected $table = 'customer_progress';
    protected $fillable = [
        'customer_id',
        'material_id',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status'])
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Progress materi dimulai',
                'updated' => 'Progress materi diperbarui',
                default   => $eventName,
            })
            ->logOnlyDirty();
    }
}
