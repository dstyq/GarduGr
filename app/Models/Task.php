<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function taskGroups()
    {
        return $this->belongsToMany(TaskGroup::class);
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
