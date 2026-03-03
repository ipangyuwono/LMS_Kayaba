<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
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
}
