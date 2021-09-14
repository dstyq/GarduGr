<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class);
    }

    public function assetMaterials()
    {
        return $this->hasMany(AssetMaterial::class);
    }
}
