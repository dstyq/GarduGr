<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryNotification extends Model
{
    use HasFactory;

    public function getStatus()
    {
        if ($this->status == false && $this->picture != "") {
            $status = "<span class='badge bg-soft-warning text-warning'>Open Door</span>";
        } elseif($this->status == true) {
            $status = "<span class='badge bg-soft-success text-success'>Online</span>";
        } else {
            $status = "<span class='badge bg-soft-danger text-danger'>Offline</span>";
        }
        return $status;
    }

    public function getLocation()
    {
        $location = $this->location;
        if (strlen($this->location) <= 3) {
            $location = optional(Location::where('id', $this->location)->first())->name;
       }
        return $location;
    }

    public function getCctv()
    {
        if ($this->type == 'nvr') {
            $link = optional(Cctv::where('location_id', $this->location)->first())->link;
        } else {
            $index = strpos($this->location, 'sensor');
            if ($index >= 0) {
                $location = substr($this->location, 0, strlen($this->location) - 7);
            } else {
                $location = $this->location;
            }

            $accessDoor = AccessDoor::where('name', 'ilike', $location)->first();
            if ($accessDoor) {
                $link = optional(Cctv::where('location_id', $accessDoor->location_id)->first())->link ?? "";
            } else {
                $link = "";
            }
        }
        return $link;
    }
}
