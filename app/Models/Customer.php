<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'mysql';
    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'kelas',
        'password',
        'departemen',
    ];

    public function progress()
    {
        return $this->hasMany(CustomerProgress::class);
    }
}
