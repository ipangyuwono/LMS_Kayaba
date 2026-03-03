<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CtUsers extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'mysql3';
    protected $table = 'ct_users_hash';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'full_name',
        'pwd',
        'approved',
        'npk',
        'dept',
        'sect',
        'subsec',
        'golongan',
        'acting',
    ];

    public function getAuthPassword():mixed
    {
        return $this->pwd;
    }
}
