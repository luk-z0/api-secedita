<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'citizen_name',
        'cpf',
        'phone',
        'email',
        'appointment_date',
        'appointment_time',
        'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
