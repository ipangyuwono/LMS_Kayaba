<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $connection = 'mysql';      // ← tambahkan ini
    protected $table = 'otps';
    protected $fillable = ['id_user', 'otp', 'expiry_date', 'send', 'send_date', 'use', 'use_date'];
}
