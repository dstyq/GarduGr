<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function assetMaterials()
    {
        return $this->hasMany(AssetMaterial::class);
    }
}
