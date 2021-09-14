<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Image;
use File;
use App\Models\MaintenanceType;
use App\Models\ReportTaskWorkOrder;
use App\Models\ScheduleMaintenance;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\UserGroup;
use App\Models\UserTechnical;
use App\Models\WorkOrder;
use App\Models\WorkOrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:work-order-list', ['only' => 'index']);
        $this->middleware('permission:work-order-create', ['only' => ['create','store']]);
        $this->middleware('permission:work-order-detail', ['only' => 'show']);
        $this->middleware('permission:work-order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:work-order-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Work Orders';
        $data['work_orders'] = WorkOrder::orderBy('id', 'desc')->whereBetween('date_generate', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->get();
        $data['date'] = date('Y-m-d');
        $data['month'] = date('Y-m');
        $data['year'] = date('Y');

        return view('work-orders.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = 'Add Work Order';
        $assets = Asset::orderBy('created_at', 'ASC')->get();

        $data['assets'] = $assets->map(function ($a) {
            $asset['name'] = '';
            $asset['id'] = $a->id;
            
            if ($a->parent()->count() > 0) {
                $asset['name'] = $this->hasParent($a, '');
            }

            $asset['name'] .= $a->name;

            return $asset;
        });
        $data['work_order_statuses'] = WorkOrderStatus::get();
        $data['maintenance_types'] = MaintenanceType::get();
        $data['tasks'] = Task::get();
        $data['task_groups'] = TaskGroup::get();
        $data['schedule_maintenances'] = ScheduleMaintenance::get();
        $data['user_technicals'] = UserTechnical::get();
        $data['user_groups'] = UserGroup::get();

        return view('work-orders.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'asset_id' => ['required'],
            'work_order_status_id' => ['required'],
            'maintenance_type_id' => ['required'],
            'schedule_maintenance_id' => ['nullable'],
            'user_group_id' => ['nullable'],
            'priority' => ['required', 'in:lowest,low,medium,high,highest'],
            'description' => ['nullable', 'min:5'],
            'suggested_completion_date' => ['required'],
            'actual_completion_date' => ['nullable'],
            'completion_notes' => ['nullable'],
            'tasks' => ['nullable'],
            'task_groups' => ['nullable'],
            'user_technicals' => ['nullable'],
            'user_technical_groups' => ['nullable'],
            'referenceId' => ['nullable'],
        ]);

        $data['name'] = $request->get('name');
        $data['asset_id'] = $request->get('asset_id');
        $data['work_order_status_id'] = $request->get('work_order_status_id');
        $data['maintenance_type_id'] = $request->get('maintenance_type_id') ;
        $data['schedule_maintenance_id'] = ($request->get('schedule_maintenance_id') == 0) ? null : $request->get('schedule_maintenance_id') ;
        $data['priority'] = $request->get('priority');
        $data['description'] = $request->get('description');
        $data['suggested_completion_date'] = $request->get('suggested_completion_date');
        $data['actual_completion_date'] = $request->get('actual_completion_date');
        $data['completion_notes'] = $request->get('completion_notes');
        $data['date_generate'] = date('Y-m-d H:i');
        $task_id = [];
        if ($request->get('tasks')) {
            foreach ($request->get('tasks') as $task) {
                if (!in_array($task, $task_id)) {
                    array_push($task_id, $task);
                }
            }
        }
        
        if ($request->get('task_groups')) {
            foreach ($request->get('task_groups') as $id) {
                $task_group = TaskGroup::where('id', $id)->first();
                foreach ($task_group->tasks as $task) {
                    if (!in_array($task->id, $task_id)) {
                        array_push($task_id, $task->id);
                    }
                }
            }
        }

        $work_order = WorkOrder::create($data);
        $work_order->userTechnicals()->attach($request->get('user_technicals'));
        $work_order->userGroups()->attach($request->get('user_technical_groups'));
        $work_order->tasks()->attach($request->get('tasks'));
        $work_order->taskGroups()->attach($request->get('task_groups'));
        $work_order->documents()->attach($request->get('referenceId'));

        $tasks = [];

        foreach ($task_id as $id) {
            $task = Task::where('id', $id)->first();
            $tasks[] = [
                'task_name' => $task->task,
                'status' => false,
                'work_order_id' => $work_order->id,
                'time_estimate' => $task->time_estimate,
            ];
        }

        ReportTaskWorkOrder::insert($tasks);
        

        return redirect()->route('work-orders.index')->with(['success' => 'Work Order added successfully!']);
    }

    public function show($id)
    {
        $data['page_title'] = 'Detail Work Order';
        $data['work_order'] = WorkOrder::findOrFail($id);

        return view('work-orders.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Work Order';
        $assets = Asset::orderBy('created_at', 'ASC')->get();

        $data['assets'] = $assets->map(function ($a) {
            $asset['name'] = '';
            $asset['id'] = $a->id;
            
            if ($a->parent()->count() > 0) {
                $asset['name'] = $this->hasParent($a, '');
            }

            $asset['name'] .= $a->name;

            return $asset;
        });
        $data['work_order_statuses'] = WorkOrderStatus::get();
        $data['maintenance_types'] = MaintenanceType::get();
        $data['tasks'] = Task::get();
        $data['task_groups'] = TaskGroup::get();
        $data['schedule_maintenances'] = ScheduleMaintenance::get();
        $data['user_technicals'] = UserTechnical::get();
        $data['user_groups'] = UserGroup::get();
        $data['work_order'] = WorkOrder::findOrFail($id);

        return view('work-orders.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'asset_id' => ['required'],
            'work_order_status_id' => ['required'],
            'maintenance_type_id' => ['required'],
            'schedule_maintenance_id' => ['nullable'],
            'priority' => ['required', 'in:lowest,low,medium,high,highest'],
            'description' => ['nullable', 'min:5'],
            'suggested_completion_date' => ['required'],
            'actual_completion_date' => ['nullable'],
            'completion_notes' => ['nullable'],
            'tasks' => ['nullable'],
            'task_groups' => ['nullable'],
            'user_technicals' => ['nullable'],
            'user_technical_groups' => ['nullable'],
            'referenceId' => ['nullable'],
        ]);

        $work_order = WorkOrder::findOrFail($id);
        $data['name'] = $request->get('name');
        $data['asset_id'] = $request->get('asset_id');
        $data['work_order_status_id'] = $request->get('work_order_status_id');
        $data['maintenance_type_id'] = $request->get('maintenance_type_id') ;
        $data['schedule_maintenance_id'] = ($request->get('schedule_maintenance_id') == 0) ? null : $request->get('schedule_maintenance_id') ;
        $data['priority'] = $request->get('priority');
        $data['description'] = $request->get('description');
        $data['suggested_completion_date'] = $request->get('suggested_completion_date');
        $data['actual_completion_date'] = $request->get('actual_completion_date');
        $data['completion_notes'] = $request->get('completion_notes');

        $work_order->update($data);

        $work_order->tasks()->sync($request->get('tasks'));
        $work_order->taskGroups()->sync($request->get('task_groups'));
        $work_order->userTechnicals()->sync($request->get('user_technicals'));
        $work_order->userGroups()->sync($request->get('user_technical_groups'));
        $work_order->documents()->sync($request->get('referenceId'));

        $task_id = [];
        $tasks = [];
        $task_names = [];

        if ($request->get('tasks')) {
            foreach ($request->get('tasks') as $task) {
                $task = Task::where('id', $task)->first();
                if (!in_array($task->task, $task_names)) {
                    array_push($task_names, $task->task);
                }
            }
        }


        if ($request->get('task_groups')) {
            foreach ($request->get('task_groups') as $id) {
                $task_group = TaskGroup::where('id', $id)->first();
                foreach ($task_group->tasks as $task) {
                    if (!in_array($task->task, $task_names)) {
                        array_push($task_names, strval($task->task));
                    }
                }
            }
        }

        if (!$request->get('tasks') && !$request->get('task_groups')) {
            $task_names = [0];
        }


        // Delete report task
        $task_deletes = ReportTaskWorkOrder::where('work_order_id', $work_order->id)->whereNotIn('task_name', $task_names)->get();
        foreach ($task_deletes as $task_delete) {
            $task_delete->delete();
        }

        foreach (ReportTaskWorkOrder::where('work_order_id', $work_order->id)->get() as $value) {
            $id = Task::where('task', $value->task_name)->first()->id;
            array_push($task_id, strval($id));
        }

        if ($request->get('tasks')) {
            foreach ($request->get('tasks') as $task) {
                if (!in_array($task, $task_id)) {
                    $task = Task::where('id', $task)->first();
                    $tasks[] = [
                        'task_name' => $task->task,
                        'status' => false,
                        'work_order_id' => $work_order->id,
                        'time_estimate' => $task->time_estimate,
                    ];
                    array_push($task_id, $task->id);
                }
            }
        }

        if ($request->get('task_groups')) {
            foreach ($request->get('task_groups') as $id) {
                $task_group = TaskGroup::where('id', $id)->first();
                foreach ($task_group->tasks as $task) {
                    if (!in_array($task->id, $task_id)) {
                        $tasks[] = [
                            'task_name' => $task->task,
                            'status' => false,
                            'work_order_id' => $work_order->id,
                            'time_estimate' => $task->time_estimate,
                        ];
                        array_push($task_id, $task->id);
                    }
                }
            }
        }

        ReportTaskWorkOrder::insert($tasks);

        return redirect()->route('work-orders.index')->with(['success' => 'Work Order updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            // Delete scheduleMaintenance
            $work_order = WorkOrder::findOrFail($id);
            $work_order->tasks()->detach();
            $work_order->taskGroups()->detach();
            $work_order->userTechnicals()->detach();
            $work_order->userGroups()->detach();
            $work_order->reportTaskWorkOrders()->delete();
            $work_order->documents()->detach();
            $images = Image::where('work_order_id', $id)->get();
            foreach ($images as $image) {
                $file_path = public_path('img/work-orders/'.$image->name);
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }

                $image->delete();
            }
            $work_order->delete();
        });

        Session::flash('success', 'Work Order deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function hasParent($asset, $prev_name)
    {   
        $data['name'] = '';
        if ($asset->parent()->count() > 0) {
            $parent =  $asset->parent;
            $data['name'] .= ($parent->parent != null)  ?  $this->hasParent($parent, $parent->name . ' => ') : $parent->name . ' => ';
        }
        $data['name'] .= $prev_name;

        return $data['name'];
    }
}
