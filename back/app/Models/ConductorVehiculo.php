<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductorVehiculo extends Model
{
    protected $table = 'conductorvehiculo';


    public function conductor()
    {
        return $this->belongsTo('App\Models\Conductor','conductor_id');
    }
    public function vehiculo()
    {
        return $this->belongsTo('App\Models\Vehiculo','vehiculo_id');
    }
}
