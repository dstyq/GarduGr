<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gardu extends Model
{
    protected $table = 'gardu'; 
    protected $fillable = [
        'gardu_induk',
    ];

    public function impedansiTrafo()
    {
        return $this->hasMany(ImpedansiTrafo::class, 'id_gardu');
    }
}
