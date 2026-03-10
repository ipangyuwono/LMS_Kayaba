<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Orders extends Model
{
    use LogsActivity;

    protected $fillable = [
        'order_id',
        'service_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'status',
        'snap_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'total_price'])
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Order baru dibuat',
                'updated' => 'Order diperbarui',
                'deleted' => 'Order dihapus',
                default   => $eventName,
            })
            ->logOnlyDirty();
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
