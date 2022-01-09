<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'rol';
    //!RELACION DE UNO A UNO CON USUARIOS
    public function usuario()
    {
        return $this->hasOne('App\Models\User');
    }
}
