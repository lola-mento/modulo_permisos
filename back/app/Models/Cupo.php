<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupo extends Model
{
    protected $table = 'cupo';
    use HasFactory;

    public function cupopropietario()
    {
        return $this->hasMany('App\Models\CupoPropietario');
    }
    public function transaccion()
    {
        return $this->hasMany('App\Models\Transaccion');
    }
    public function vehiculo()
    {
        return $this->hasOne('App\Models\Vehiculo');
    }
}
