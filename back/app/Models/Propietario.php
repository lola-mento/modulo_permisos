<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    protected $table = 'propietario';
    use HasFactory;
    public function cupopropietario()
    {
        return $this->hasMany('App\Models\CupoPropietario');
    }
}
