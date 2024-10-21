<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gardu extends Model
{
    use HasFactory;

    protected $table = 'gardu';
    
    protected $fillable = [
        'gardu_induk',
    ];

    public function impedansiTrafo()
    {
        return $this->hasMany(ImpedansiTrafo::class, 'id_gardu');
    }
}
