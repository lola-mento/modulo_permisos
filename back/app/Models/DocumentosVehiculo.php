<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosVehiculo extends Model
{
    protected $table = 'documentosvehiculo';
    use HasFactory;
    public function vehiculo()
    {
        return $this->belongsTo('App\Models\Vehiculo','vehiculo_id');
    }
}
