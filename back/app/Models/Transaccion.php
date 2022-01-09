<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transaccion';
    use HasFactory;
    public function cupo()
    {
        return $this->belongsTo('App\Models\Cupo','cupo_id');
    }
}
