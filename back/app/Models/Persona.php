<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

//RELACION DE UNO A UNO CON USUARIO
public function user()
{
    return $this->hasOne('App\Models\User');
}
public function empleado()
    {
        return $this->hasMany('App\Models\Empleado');
    }


}
