<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoConductor extends Model
{
    protected $table = 'documentoconductor';
    use HasFactory;
    public function conductor()
    {
        return $this->belongsTo('App\Models\Conductor','conductor_id');
    }
}
