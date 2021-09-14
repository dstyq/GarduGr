<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAssetMaterial extends Model
{
    use HasFactory;

    public function prevMaterial()
    {
        return $this->belongsTo(AssetMaterial::class, 'prev_material');
    }

    public function currentMaterial()
    {
        return $this->belongsTo(AssetMaterial::class, 'current_material');
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
