<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'purchase_at',
        'purchase_price',
        'description',
        'status',
        'model',
        'brand',
        'category_id',
        'type_id',
        'location_id',
        'image',
        'parent_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(Asset::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Asset::class, 'parent_id');
    }

    public function boms()
    {
        return $this->belongsToMany(Bom::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function scheduleMaintenances()
    {
        return $this->hasMany(ScheduleMaintenance::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function assetMaterials()
    {
        return $this->hasMany(AssetMaterial::class);
    }
}
