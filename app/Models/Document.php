<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class);
    }

    public function scheduleMaintenances()
    {
        return $this->belongsToMany(ScheduleMaintenance::class);
    }
}
