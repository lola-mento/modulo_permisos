<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';

    public function area()
    {
        return $this->hasOne('App\Models\Area');
    }
    public function cargo()
    {
        return $this->hasOne('App\Models\Cargo');
    }
    public function permiso()
    {
        return $this->hasMany('App\Models\Permiso');
    }
    public function persona()
    {
        return $this->hasOne('App\Models\Persona');
    }


}
