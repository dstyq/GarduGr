<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gardu extends Model
{
    protected $table = 'gardu'; 

    protected $fillable = [
        'gardu_induk',
    ];

    // Relasi ke model ImpedansiTrafo
    public function impedansiTrafo()
    {
        return $this->hasMany(ImpedansiTrafo::class, 'id_gardu');
    }
}
