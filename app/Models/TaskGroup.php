<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGroup extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
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
