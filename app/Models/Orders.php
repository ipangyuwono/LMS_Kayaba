<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
