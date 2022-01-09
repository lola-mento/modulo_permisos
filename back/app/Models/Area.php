<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';

    public function empleado()
    {
        return $this->hasMany('App\Models\Empleado');
    }
}
