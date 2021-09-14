<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserTechnical extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'username',
        'phone',
        'whatsapp',
        'address',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function userGroups()
    {
        return $this->belongsToMany(UserGroup::class)->withTimestamps();
    }

    public function scheduleMaintenances()
    {
        return $this->belongsToMany(ScheduleMaintenance::class);
    }

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class);
    }

    public function reportTaskWorkOrders()
    {
        return $this->hasMany(ReportTaskWorkOrder::class);
    }
}
