<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTaskWorkOrder extends Model
{
    use HasFactory;

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function userTechnical()
    {
        return $this->belongsTo(UserTechnical::class);
    }
}
