<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'is_active',
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
