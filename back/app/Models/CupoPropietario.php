<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupoPropietario extends Model
{
    protected $table = 'cupopropietario';
    use HasFactory;
    public function cupo()
    {
        return $this->belongsTo('App\Models\Cupo','cupo_id');
    }
    public function propietario()
    {
        return $this->belongsTo('App\Models\Propietario','propietario_id');
    }
}
