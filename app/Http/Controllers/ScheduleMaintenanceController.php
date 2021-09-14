<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Image;
use App\Models\MaintenanceType;
use App\Models\ReportTaskWorkOrder;
use App\Models\ScheduleMaintenance;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\UserGroup;
use App\Models\UserTechnical;
use App\Models\WorkOrder;
use App\Models\WorkOrderStatus;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ScheduleMaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:maintenance-list', ['only' => 'index']);
        $this->middleware('permission:maintenance-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:maintenance-detail', ['only' => 'show']);
        $this->middleware('permission:maintenance-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:maintenance-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Schedule Maintenance';
        $data['schedule_maintenances'] = ScheduleMaintenance::orderBy('id', 'desc')->get();

        return view('schedule-maintenances.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Schedule Maintenance';
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
        $data['user_technicals'] = UserTechnical::get();
        $data['user_groups'] = UserGroup::get();
        $data['months'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $number = ScheduleMaintenance::get()->count();
        $data['code'] = $this->generateCode($number);

        while (ScheduleMaintenance::where('code', $data['code'])->get()->count() > 0) {
            $data['code'] = $this->generateCode($number++);
        }

        return view('schedule-maintenances.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:schedule_maintenances,code'],
            'name' => ['required', 'string'],
            'asset_id' => ['required'],
            'work_order_status_id' => ['required'],
            'maintenance_type_id' => ['required'],
            'priority' => ['required', 'in:lowest,low,medium,high,highest'],
            'description' => ['nullable', 'min:5'],
            'status' => ['required', 'in:0,1'],
            'schedule' => ['required', 'in:day,week,month,year'],
            'hour' => ['required'],
            'day_of_month' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'day') || ($request->get('schedule') == 'month') || ($request->get('schedule') == 'year');
            }),
            'month' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'month') || ($request->get('schedule') == 'year');
            }),
            'week' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'week');
            }),
            'day_of_week' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'week');
            }),
            'tasks' => ['nullable'],
            'task_groups' => ['nullable'],
            'user_technicals' => ['nullable'],
            'user_technical_groups' => ['nullable'],
            'referenceId' => ['nullable'],
        ]);

        $scheduleMaintenance = new ScheduleMaintenance();
        $scheduleMaintenance->code = $request->get('code');
        $scheduleMaintenance->name = $request->get('name');
        $scheduleMaintenance->asset_id = $request->get('asset_id');
        $scheduleMaintenance->work_order_status_id = $request->get('work_order_status_id');
        $scheduleMaintenance->maintenance_type_id = $request->get('maintenance_type_id');
        $scheduleMaintenance->priority = $request->get('priority');
        $scheduleMaintenance->description = $request->get('description');
        $scheduleMaintenance->status = $request->get('status');
        $date = explode(" - ",$request->get('date_range'));
        $scheduleMaintenance->start_date = date('Y-m-d', strtotime(str_replace('/', '-', $date[0])));
        $scheduleMaintenance->end_date = date('Y-m-d', strtotime(str_replace('/', '-', $date[1])));
        $scheduleMaintenance->schedule = $request->get('schedule');
        $scheduleMaintenance->minute = 0;
        $scheduleMaintenance->hour = $request->get('hour');
        $scheduleMaintenance->day_of_month = $request->get('day_of_month');
        $scheduleMaintenance->month = $request->get('month');
        $scheduleMaintenance->week = $request->get('week');
        $scheduleMaintenance->day_of_week = $request->get('day_of_week') ? json_encode($request->get('day_of_week')) : null;
        $scheduleMaintenance->year = 1;

        $scheduleMaintenance->save();
        $scheduleMaintenance->tasks()->attach($request->get('tasks'));
        $scheduleMaintenance->taskGroups()->attach($request->get('task_groups'));
        $scheduleMaintenance->userTechnicals()->attach($request->get('user_technicals'));
        $scheduleMaintenance->userGroups()->attach($request->get('user_technical_groups'));
        $scheduleMaintenance->documents()->attach($request->get('referenceId'));

        foreach ($this->createWorkOrders($request->all()) as $key => $value) {
            $data['name'] = $scheduleMaintenance->name . ' ' . ($key + 1);
            $data['asset_id'] = $scheduleMaintenance->asset_id;
            $data['work_order_status_id'] = $scheduleMaintenance->work_order_status_id;
            $data['maintenance_type_id'] = $scheduleMaintenance->maintenance_type_id;
            $data['schedule_maintenance_id'] = $scheduleMaintenance->id;
            $data['priority'] = $scheduleMaintenance->priority;
            $data['description'] = $scheduleMaintenance->description;
            $data['date_generate'] = $value;
            $task_id = [];

            $work_order = WorkOrder::create($data);

            // Add relation task
            if ($scheduleMaintenance->tasks->count() != 0) {
                $ids = $scheduleMaintenance->tasks->pluck('id');
                $work_order->tasks()->attach($ids);

                foreach ($scheduleMaintenance->tasks->pluck('id') as $task) {
                    if (!in_array($task, $task_id)) {
                        array_push($task_id, $task);
                    }
                }
            }

            // Add relation task group
            if ($scheduleMaintenance->taskGroups->count() != 0) {
                $ids = $scheduleMaintenance->taskGroups->pluck('id');
                $work_order->taskGroups()->attach($ids);

                foreach ($scheduleMaintenance->taskGroups->pluck('id') as $id) {
                    $task_group = TaskGroup::where('id', $id)->first();
                    foreach ($task_group->tasks as $task) {
                        if (!in_array($task->id, $task_id)) {
                            array_push($task_id, $task->id);
                        }
                    }
                }
            }

            // Add relation user technical
            if ($scheduleMaintenance->userTechnicals->count() != 0) {
                $ids = $scheduleMaintenance->userTechnicals->pluck('id');
                $work_order->userTechnicals()->attach($ids);
            }

            // Add relation user group
            if ($scheduleMaintenance->userGroups->count() != 0) {
                $ids = $scheduleMaintenance->userGroups->pluck('id');
                $work_order->userGroups()->attach($ids);
            }

            // Add relation reference document
            if ($scheduleMaintenance->documents->count() != 0) {
                $ids = $scheduleMaintenance->documents->pluck('id');
                $work_order->documents()->attach($ids);
            }

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
        }

        return redirect()->route('schedule-maintenances.index')->with(['success' => 'Schedule Maintenance added successfully!']);
    }

    public function show($id)
    {
        $data['page_title'] = 'Detail Maintenance';
        $data['schedule_maintenance'] = ScheduleMaintenance::findOrFail($id);

        return view('schedule-maintenances.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Schedule Management';
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
        $data['user_technicals'] = UserTechnical::get();
        $data['user_groups'] = UserGroup::get();
        $data['schedule_maintenance'] = ScheduleMaintenance::findOrFail($id);
        $data['months'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('schedule-maintenances.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:schedule_maintenances,code,' . $id],
            'name' => ['required', 'string'],
            'asset_id' => ['required'],
            'work_order_status_id' => ['required'],
            'maintenance_type_id' => ['required'],
            'priority' => ['required', 'in:lowest,low,medium,high,highest'],
            'description' => ['nullable', 'min:5'],
            'status' => ['required', 'in:0,1'],
            'schedule' => ['required', 'in:hour,day,week,month,year'],
            'hour' => ['required'],
            'day_of_month' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'day') || ($request->get('schedule') == 'month') || ($request->get('schedule') == 'year');
            }),
            'month' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'month') || ($request->get('schedule') == 'year');
            }),
            'week' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'week');
            }),
            'day_of_week' => Rule::requiredIf(function () use ($request) {
                return ($request->get('schedule') == 'week');
            }),
            'tasks' => ['nullable'],
            'task_groups' => ['nullable'],
            'user_technicals' => ['nullable'],
            'user_technical_groups' => ['nullable'],
            'referenceId' => ['nullable'],
        ]);

        $scheduleMaintenance = ScheduleMaintenance::findOrFail($id);
        $scheduleMaintenance->code = $request->get('code');
        $scheduleMaintenance->name = $request->get('name');
        $scheduleMaintenance->asset_id = $request->get('asset_id');
        $scheduleMaintenance->work_order_status_id = $request->get('work_order_status_id');
        $scheduleMaintenance->maintenance_type_id = $request->get('maintenance_type_id');
        $scheduleMaintenance->priority = $request->get('priority');
        $scheduleMaintenance->description = $request->get('description');
        $scheduleMaintenance->status = $request->get('status');
        $date = explode(" - ",$request->get('date_range'));
        $scheduleMaintenance->start_date = date('Y-m-d', strtotime(str_replace('/', '-', $date[0])));
        $scheduleMaintenance->end_date = date('Y-m-d', strtotime(str_replace('/', '-', $date[1])));
        $scheduleMaintenance->schedule = $request->get('schedule');
        $scheduleMaintenance->minute = 0;
        $scheduleMaintenance->hour = $request->get('hour');
        $scheduleMaintenance->day_of_month = $request->get('day_of_month');
        $scheduleMaintenance->month = $request->get('month');
        $scheduleMaintenance->week = $request->get('week');
        $scheduleMaintenance->day_of_week = $request->get('day_of_week') ? json_encode($request->get('day_of_week')) : null;
        $scheduleMaintenance->year = 1;
        $scheduleMaintenance->save();

        $scheduleMaintenance->tasks()->sync($request->get('tasks'));
        $scheduleMaintenance->taskGroups()->sync($request->get('task_groups'));
        $scheduleMaintenance->userTechnicals()->sync($request->get('user_technicals'));
        $scheduleMaintenance->userGroups()->sync($request->get('user_technical_groups'));
        $scheduleMaintenance->documents()->sync($request->get('referenceId'));

        // delete work order
        foreach ($scheduleMaintenance->workOrders->all() as $work_order) {
            if ($work_order->date_generate > date('Y-m-d H:i')) {
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
            }
        }

        // create work order
        foreach ($this->createWorkOrders($request->all()) as $key => $value) {
            if ($value > date('Y-m-d H:i')) {
                $data['name'] = $scheduleMaintenance->name . ' ' . ($key + 1);
                $data['asset_id'] = $scheduleMaintenance->asset_id;
                $data['work_order_status_id'] = $scheduleMaintenance->work_order_status_id;
                $data['maintenance_type_id'] = $scheduleMaintenance->maintenance_type_id;
                $data['schedule_maintenance_id'] = $scheduleMaintenance->id;
                $data['priority'] = $scheduleMaintenance->priority;
                $data['description'] = $scheduleMaintenance->description;
                $data['date_generate'] = $value;
                $task_id = [];

                $work_order = WorkOrder::create($data);

                // Add relation task
                if ($scheduleMaintenance->tasks->count() != 0) {
                    $ids = $scheduleMaintenance->tasks->pluck('id');
                    $work_order->tasks()->attach($ids);

                    foreach ($scheduleMaintenance->tasks->pluck('id') as $task) {
                        if (!in_array($task, $task_id)) {
                            array_push($task_id, $task);
                        }
                    }
                }

                // Add relation task group
                if ($scheduleMaintenance->taskGroups->count() != 0) {
                    $ids = $scheduleMaintenance->taskGroups->pluck('id');
                    $work_order->taskGroups()->attach($ids);

                    foreach ($scheduleMaintenance->taskGroups->pluck('id') as $id) {
                        $task_group = TaskGroup::where('id', $id)->first();
                        foreach ($task_group->tasks as $task) {
                            if (!in_array($task->id, $task_id)) {
                                array_push($task_id, $task->id);
                            }
                        }
                    }
                }

                // Add relation user technical
                if ($scheduleMaintenance->userTechnicals->count() != 0) {
                    $ids = $scheduleMaintenance->userTechnicals->pluck('id');
                    $work_order->userTechnicals()->attach($ids);
                }

                // Add relation user group
                if ($scheduleMaintenance->userGroups->count() != 0) {
                    $ids = $scheduleMaintenance->userGroups->pluck('id');
                    $work_order->userGroups()->attach($ids);
                }

                // Add relation reference document
                if ($scheduleMaintenance->documents->count() != 0) {
                    $ids = $scheduleMaintenance->documents->pluck('id');
                    $work_order->documents()->attach($ids);
                }


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
            }
        }

        return redirect()->route('schedule-maintenances.index')->with(['success' => 'Schedule Maintenance updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            // Delete scheduleMaintenance
            $scheduleMaintenance = ScheduleMaintenance::findOrFail($id);
            WorkOrder::where('schedule_maintenance_id', $id)->update(['schedule_maintenance_id' => null]);
            $scheduleMaintenance->tasks()->detach();
            $scheduleMaintenance->taskGroups()->detach();
            $scheduleMaintenance->userTechnicals()->detach();
            $scheduleMaintenance->documents()->detach();
            $scheduleMaintenance->userGroups()->detach();
            $scheduleMaintenance->delete();
        });

        Session::flash('success', 'Schedule Maintenance deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function generateCode($number)
    {
        $char = 'A';
        $number = $number;

        // For adjust a character
        if ($number >= 98) {
            $plus = 0;
            while ($number - 100 >= 0) {
                $plus++;
                $number -= 100;
            }
            $number++;
            // For make a code no more than 2 digits
            if (strlen($number) > 2) {
                $number--;
            }

            for ($z = 0; $z < $plus; $z++) {
                $char++;
            }
        } else {
            $number++;
        }

        return "#$char" . sprintf("%02s", $number);
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

    public function createWorkOrders($req)
    {
        $date_range = explode(" - ",$req['date_range']);
        $start_date = new DateTime(date('Y/m/d',strtotime(str_replace('/', '-', $date_range[0]))) . ' ' .$req['hour'] . ':00');
        $end_date = new DateTime(date('Y/m/d',strtotime(str_replace('/', '-', $date_range[1]))) . ' ' .$req['hour'] . ':00');
        $dates = [];

        if ($req['schedule'] == 'day') {
            for($day = clone $start_date; $day <= $end_date; $day->modify('+' . $req['day_of_month'] .' day')){
                array_push($dates, $day->format("Y-m-d H:i"));
            }
        } elseif ($req['schedule'] == 'week') {
            $end_week = clone $end_date;
            for($start_week = clone $start_date; $start_week <= $end_week->modify('sunday this week ' . $req['hour'] . ':00'); $start_week->modify('+' . $req['week'] . ' week')){
                $first_day_of_week =  clone $end_day_of_week = clone $start_week;
        
                if ($start_week == $start_date) {
                    $end_day_of_week->modify('sunday this week ' . $req['hour'] . ':00');
                } else {
                    $first_day_of_week->modify('monday this week ' . $req['hour'] . ':00');
                    $end_day_of_week->modify('sunday this week ' . $req['hour'] . ':00');
                }

                for($day = clone $first_day_of_week; $day <= $end_day_of_week; $day->modify('+1 day')){
                    if (in_array($day->format('N'), $req['day_of_week'] ?? []) && $day <= $end_date) {
                        array_push($dates, $day->format("Y-m-d H:i"));

                    }
                }
            }
        } elseif ($req['schedule'] == 'month') {
            for($month = clone $start_date; $month <= $end_date; $month->modify('first day of +' . $req['month'] . ' month')){
                $first_day_of_month = clone $last_day_of_month = clone $month;
              
                if ($month == $start_date) {
                    $last_day_of_month->modify('last day of this month ' . $req['hour'] . ':00');
                } else {
                    $first_day_of_month->modify('first day of this month ' . $req['hour'] . ':00');
                    $last_day_of_month->modify('last day of this month ' . $req['hour'] . ':00');
                }

                if ($first_day_of_month->format('j') <= $req['day_of_month'] && $last_day_of_month->format('j') >= $req['day_of_month']) {
                    array_push($dates,  $first_day_of_month->format("Y-m-" . $req['day_of_month'] . " H:i"));
                }
            }
        } elseif ($req['schedule'] == 'year') {
            $dateObj   = DateTime::createFromFormat('!m', $req['month']);
            $monthName = $dateObj->format('F');
            for($year = clone $start_date; $year <= $end_date; $year->modify('+1 year')){
                $first_month = clone $first_day = clone $last_day = clone $year;
                $first_day->modify('first day of '. $monthName  . ' ' . $req['hour'] . ':00');
                $last_day->modify('last day of '. $monthName . ' ' . $req['hour'] . ':00');
                $first_month = ($year == $start_date) ? $first_month->format("m") : $first_month->format("01");

                if ($first_month <= $req['month'] && $first_day->format('j') <= $req['day_of_month'] && $last_day->format('j') >= $req['day_of_month']) {
                    array_push($dates,  $first_day->format("Y-" . $req['month'] . "-" . $req['day_of_month'] . " H:i"));
                }
            }
        }

       return $dates;
    }

    #Fitur Generate🙏
    // public function generateWorkOrder(Request $request)
    // {
    //     $schedule = $request->get('schedule');
    //     $hour = $request->get('hour');
    //     $day_of_month = $request->get('day_of_month') ? ' = '. $request->get('day_of_month') .' ' : ' IS NULL ';
    //     $month = $request->get('month') ? ' = '. $request->get('month') .' ' : ' IS NULL ';
    //     $week = $request->get('week') ? ' = '. $request->get('week') .' ' : ' IS NULL ';
    //     // $day_of_week = $request->get('day_of_week') ? ' = '. $request->get('day_of_week') .' ' : ' IS NULL ';
    //     $year = $request->get('year') ? ' = '. $request->get('year') .' ' : ' IS NULL ';
    //     $date = new DateTime();
    //     $date_now = $date->format('Y-m-d');

    //     // $schedule_maintenances = ScheduleMaintenance::where([['status', '=', true], ['schedule', '=', $schedule], ['hour', '=', $hour], ['day_of_month', '=', $day_of_month], ['month', '=', $month], ['week', '=', $week], ['day_of_week', '=', $day_of_week], ['year', '=', $year]])->get();
    //     $schedule_maintenances = ScheduleMaintenance::whereRaw(" status=? AND schedule=? AND hour=". $hour ." AND day_of_month". $day_of_month ." AND month". $month ." AND week". $week ." AND year". $year ." AND start_date >=". $date_now .":date", array(true, $schedule))->get();
    //     return $schedule_maintenances;
    //     if ($schedule_maintenances->count() > 0) {
    //         foreach ($schedule_maintenances as $schedule_maintenance) {
    //             $number = WorkOrder::where('schedule_maintenance_id', $schedule_maintenance->id)->count() + 1;
    //             $data['name'] = $schedule_maintenance->name . ' ' . $number;
    //             $data['asset_id'] = $schedule_maintenance->asset_id;
    //             $data['work_order_status_id'] = $schedule_maintenance->work_order_status_id;
    //             $data['maintenance_type_id'] = $schedule_maintenance->maintenance_type_id;
    //             $data['schedule_maintenance_id'] = $schedule_maintenance->id;
    //             $data['priority'] = $schedule_maintenance->priority;
    //             $data['description'] = $schedule_maintenance->description;
    //             $task_id = [];

    //             $work_order = WorkOrder::create($data);

    //             // Add relation task
    //             if ($schedule_maintenance->tasks->count() != 0) {
    //                 $ids = $schedule_maintenance->tasks->pluck('id');
    //                 $work_order->tasks()->attach($ids);

    //                 foreach ($schedule_maintenance->tasks->pluck('id') as $task) {
    //                     if (!in_array($task, $task_id)) {
    //                         array_push($task_id, $task);
    //                     }
    //                 }
    //             }

    //             // Add relation task group
    //             if ($schedule_maintenance->taskGroups->count() != 0) {
    //                 $ids = $schedule_maintenance->taskGroups->pluck('id');
    //                 $work_order->taskGroups()->attach($ids);

    //                 foreach ($schedule_maintenance->taskGroups->pluck('id') as $id) {
    //                     $task_group = TaskGroup::where('id', $id)->first();
    //                     foreach ($task_group->tasks as $task) {
    //                         if (!in_array($task->id, $task_id)) {
    //                             array_push($task_id, $task->id);
    //                         }
    //                     }
    //                 }
    //             }

    //             // Add relation user technical
    //             if ($schedule_maintenance->userTechnicals->count() != 0) {
    //                 $ids = $schedule_maintenance->userTechnicals->pluck('id');
    //                 $work_order->userTechnicals()->attach($ids);
    //             }

    //             // Add relation user group
    //             if ($schedule_maintenance->userGroups->count() != 0) {
    //                 $ids = $schedule_maintenance->userGroups->pluck('id');
    //                 $work_order->userGroups()->attach($ids);
    //             }

    //             $tasks = [];

    //             foreach ($task_id as $id) {
    //                 $task = Task::where('id', $id)->first();
    //                 $tasks[] = [
    //                     'task_name' => $task->task,
    //                     'status' => false,
    //                     'work_order_id' => $work_order->id,
    //                     'time_estimate' => $task->time_estimate,
    //                 ];
    //             }

    //             ReportTaskWorkOrder::insert($tasks);
    //         }

    //         return "Success generate " . $schedule_maintenances->count() . " work order";
    //     } else {
    //         return "No schedule maintenance";
    //     }
    // }
}
