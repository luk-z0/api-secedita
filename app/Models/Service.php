<?php

namespace App\Models;


use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'sector',
        'is_active',
        'availability'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
