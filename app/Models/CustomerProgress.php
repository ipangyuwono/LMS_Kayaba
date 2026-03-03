<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProgress extends Model
{
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
}
