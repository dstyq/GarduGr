<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function boms()
    {
        return $this->belongsToMany(Bom::class);
    }

    public function assetMaterials()
    {
        return $this->hasMany(AssetMaterial::class);
    }
}
