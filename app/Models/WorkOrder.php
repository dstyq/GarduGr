<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asset_id',
        'work_order_status_id',
        'maintenance_type_id',
        'schedule_maintenance_id',
        'priority',
        'description',
        'suggested_completion_date',
        'actual_completion_date',
        'completion_notes',
        'date_generate'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function workOrderStatus()
    {
        return $this->belongsTo(WorkOrderStatus::class);
    }

    public function maintenanceType()
    {
        return $this->belongsTo(MaintenanceType::class);
    }

    public function userTechnicals()
    {
        return $this->belongsToMany(UserTechnical::class);
    }

    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class);
    }

    public function scheduleMaintenance()
    {
        return $this->belongsTo(ScheduleMaintenance::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function taskGroups()
    {
        return $this->belongsToMany(TaskGroup::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function reportTaskWorkOrders()
    {
        return $this->hasMany(ReportTaskWorkOrder::class);
    }

    public function reportAssetMaterials()
    {
        return $this->hasMany(ReportAssetMaterial::class);
    }
}
