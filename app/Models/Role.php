<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\RoleEnum;

class Role extends Model
{
    protected $fillable = ['name', 'label', 'level'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
