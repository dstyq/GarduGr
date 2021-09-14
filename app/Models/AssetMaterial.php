<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['asset_id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    public function prevMaterials()
    {
        return $this->hasMany(AssetMaterial::class, 'prev_material');
    }

    public function currentMaterials()
    {
        return $this->hasMany(AssetMaterial::class, 'current_material');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
