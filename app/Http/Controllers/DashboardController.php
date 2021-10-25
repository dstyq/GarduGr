<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Bom;
use App\Models\ScheduleMaintenance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:dashbord-overview', ['only' => 'overview']);
        $this->middleware('permission:dashbord-maps-cctv', ['only' => 'mapsCctv']);
        $this->middleware('permission:dashbord-maps-access-door', ['only' => 'mapsAccessDoor']);
    }

    public function overview()
    {   
        $data['page_title'] = 'Overview';
        $data['asset_count'] = Asset::all()->count();
        $data['schedule_maintenance_count'] = ScheduleMaintenance::all()->count();
        $data['bom_count'] = Bom::all()->count();

        $data['work_orders'] = DB::table('work_orders')
            ->select(DB::raw("date_trunc('day', date_generate) as date, count(*) as total_wo"))
            ->whereBetween('date_generate', [
                Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00'))->subDays(7),
                Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59'))
            ])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $data['work_order_count']['date'] = [];
        $data['work_order_count']['value'] = [];

        foreach ($data['work_orders'] as $work_order) {
            array_push( $data['work_order_count']['date'], date('d-m-Y', strtotime($work_order->date)));
            array_push($data['work_order_count']['value'], $work_order->total_wo);
        }

        return view('dashboard.overview', $data);
    }

    public function mapsCctv()
    {
        $data['page_title'] = 'Maps CCTV';

        return view('dashboard.maps', $data);
    }
    
    public function mapsAccessDoor()
    {
        $data['page_title'] = 'Maps Access Door';

        return view('dashboard.maps-access', $data);
    }
}
