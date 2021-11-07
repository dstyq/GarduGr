<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryNotification extends Model
{
    use HasFactory;

    public function getStatus()
    {
        if ($this->status == false) {
            $status = 'Offline';
        } elseif($this->status == true) {
            $status = "Online";
        } else {
            $status = "N/A";
        }
        return $status;
    }

    public function getLocation()
    {
        $location = Location::where('id', $this->location)->first();
        return $location;
    }
}
