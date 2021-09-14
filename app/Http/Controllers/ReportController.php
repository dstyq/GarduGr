<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ReportTaskWorkOrder;
use PDF;
use App\Models\ScheduleMaintenance;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:report-maintenance', ['only' => 'index']);
    }

    public function index()
    {
        $data['page_title'] = 'Reports';
        $data['schedule_maintenances'] = ScheduleMaintenance::orderBy('id', 'desc')->get();

        return view('report.index', $data);
    }

    public function viewWorkOrderReport($id)
    {
        $data['work_order'] = WorkOrder::findOrFail($id);
        $task_count = ReportTaskWorkOrder::where('work_order_id', $id)->where('status', true)->count();
        $task_done_count = $data['work_order']->reportTaskWorkOrders->count();
        $data['task_complete'] = $task_count != 0 ?  round(($task_count / $task_done_count) * 100) . '%' : '0%';

        $pdf = PDF::loadview('report.work-order-report',$data);
    	return $pdf->stream();        
    }

    public function viewMaintenanceReport($id)
    {
        $data['schedule_maintenance'] = ScheduleMaintenance::findOrFail($id);
        $data['work_orders'] = WorkOrder::where('schedule_maintenance_id', $id)->orderBy('created_at', 'DESC')->get();

        $pdf = PDF::loadview('report.maintenance-report',$data);
    	return $pdf->stream();        
    }

    public function viewAssetReport($id)
    {
        $data['asset'] = Asset::findOrFail($id);
        $data['boms'] = Asset::findOrFail($id)->boms;
        $data['material'] = [];
        foreach ($data['boms'] as $bom) {
            foreach ($bom->materials as $material) {
                if (!in_array($material->name, $data['material'])) {
                    array_push($data['material'], $material->name);
                }
            }
        }

        $pdf = PDF::loadview('report.asset-report',$data);
    	return $pdf->stream();        
    }
}
