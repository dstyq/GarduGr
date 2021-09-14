<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    public function userTechnicals()
    {
        return $this->belongsToMany(UserTechnical::class);
    }

    public function scheduleMaintenances()
    {
        return $this->belongsToMany(ScheduleMaintenance::class);
    }

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class);
    }
}
