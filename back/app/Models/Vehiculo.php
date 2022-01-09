<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculo';

    public function cupo()
    {
        return $this->hasOne('App\Models\Cupo');
    }
    public function documentosvehiculo()
    {
        return $this->hasMany('App\Models\DocumentosVehiculo');
    }
    public function conductorvehiculo()
    {
        return $this->hasMany('App\Models\ConductorVehiculo');
    }
}
