<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends Model
{
    use LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'kelas', 'departemen'])
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'Customer baru ditambahkan',
                'updated' => 'Data customer diperbarui',
                'deleted' => 'Customer dihapus',
                default   => $eventName,
            })
            ->logOnlyDirty();
    }
}
