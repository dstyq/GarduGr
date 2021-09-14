<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Asset;
use App\Models\AssetMaterial;
use App\Models\Image;
use App\Models\MaintenanceType;
use App\Models\Material;
use App\Models\ReportAssetMaterial;
use App\Models\ScheduleMaintenance;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\UserGroup;
use App\Models\UserTechnical;
use App\Models\WorkOrder;
use App\Models\WorkOrderStatus;
Use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserTechnicalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-technical-list', ['only' => 'index']);
        $this->middleware('permission:user-technical-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-technical-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-technical-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $data['page_title'] = 'List User Technicals';
        $data['user_technicals'] = UserTechnical::orderby('id', 'asc')->get();

        return view('user-technicals.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add User Technicals';

        return view('user-technicals.create', $data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'username'   => 'required|unique:user_technicals,username|alpha_dash',
            'phone' => 'required',
            'whatsapp' => 'required',
            'address' => 'required',
            'email'   => 'required|email|unique:user_technicals,email',
            'password' => 'required|min:8',
            'from' => 'required',
        ]);

        $user_technical = new UserTechnical();
        $user_technical->name = $validateData['name'];
        $user_technical->username = $validateData['username'];
        $user_technical->phone = $validateData['phone'];
        $user_technical->whatsapp = $validateData['whatsapp'];
        $user_technical->address = $validateData['address'];
        $user_technical->email = $validateData['email'];
        $user_technical->password = Hash::make($validateData['password']);
        $user_technical->from = $validateData['from'];

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/user-technicals/');
            $image->move($destinationPath, $name);
            $user_technical->avatar = $name;
        }

        $user_technical->save();

        if ($request->get('from') == 'user_technical') {
            return redirect()->route('user-technicals.index')->with(['success' => 'User Technical added successfully!']);
        }else {
            return response()->json(['status' => '200', 'data' => $user_technical]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit User Technicals';
        $data['user_technical'] = UserTechnical::findOrFail($id);

        return view('user-technicals.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'username'   => 'required|alpha_dash|unique:user_technicals,username,' .$id,
            'phone' => 'required',
            'whatsapp' => 'required',
            'address' => 'required',
            'email'   => 'required|email|unique:user_technicals,email,'.$id,
        ]);

        $user_technical = UserTechnical::findOrFail($id);
        $user_technical->name = $validateData['name'];
        $user_technical->username = $validateData['username'];
        $user_technical->phone = $validateData['phone'];
        $user_technical->whatsapp = $validateData['whatsapp'];
        $user_technical->address = $validateData['address'];
        $user_technical->email = $validateData['email'];
        
         if ($request->hasFile('avatar')) {
            // Delete Img
            if ($user_technical->avatar) {
                $image_path = public_path('img/user-technicals/'.$user_technical->avatar); // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/user-technicals/');
            $image->move($destinationPath, $name);
            $user_technical->avatar = $name;
        }

        $user_technical->save();

        return redirect()->route('user-technicals.index')->with(['success' => 'User Technical edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $user_technical = UserTechnical::findOrFail($id);
            if ($user_technical->avatar) {
                $image_path = public_path('img/user-technicals/'.$user_technical->avatar); // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $user_technical->workOrders()->detach();
            $user_technical->userGroups()->detach();
            $user_technical->scheduleMaintenances()->detach();
            $user_technical->delete();
        });
        
        Session::flash('success', 'User Technicals deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function changePassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user_technical = UserTechnical::findOrFail(Auth::user()->id);

        if (Hash::check($validateData['password'], $user_technical->password)) {
            $user_technical->password = Hash::make($request->get('new_password'));
            $user_technical->save();
            
            return redirect()->route('user-technicals.edit', Auth::user()->id)->with('success', 'Password changed successfully!');
        } else {
            return redirect()->route('user-technicals.edit', Auth::user()->id)->with('failed', 'Password change failed');
        }
    }

    public function dashboard()
    {   
        $data['page_title'] = 'Dashboard';
        $ids = [];
        $workOrders = [];
        $userTechnical = Auth::guard('user-technical')->user();
        foreach ($userTechnical->workOrders()->whereNotIn('work_orders.id', $ids)->whereBetween('date_generate', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->get() as $workOrder) {
                array_push($ids, $workOrder->id);
                array_push($workOrders, $workOrder);
        }

        $userGroups = Auth::guard('user-technical')->user()->userGroups()->get();
        foreach ($userGroups as $key => $userGroup) {
            foreach ($userGroup->workOrders()->whereNotIn('work_orders.id', $ids)->whereBetween('date_generate', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->get() as $workOrder) {
                    array_push($ids, $workOrder->id);
                    array_push($workOrders, $workOrder);
            }
        }

        $data['total_work_orders'] = count($workOrders);

        return view('user-technicals.dashboard', $data);
    }

    public function getWorkOrders(Request $request)
    {
            $start_date = $request->get('date').' 00:00:00';
            $end_date = $request->get('date').' 23:59:59';
            $ids = [];
            $data['work_orders'] = [];

            if ($request->get('daterange') == 'month') {
                $start_date = date("Y-m-01 H:i:s", strtotime($request->get('date').' 00:00:00'));
                $end_date = date("Y-m-t H:i:s", strtotime($request->get('date').' 23:59:59'));
            } elseif ($request->get('daterange') == 'year') {
                $start_date = date("Y-01-01 H:i:s", strtotime($request->get('date').'-01-01 00:00:00'));
                $end_date = date("Y-12-t H:i:s", strtotime($request->get('date').'-12-31 23:59:59'));
            }
            
            $userTechnical = UserTechnical::where('id', $request->get('userId'))->first();
            foreach ($userTechnical->workOrders()->whereNotIn('work_orders.id', $ids)->orderBy('created_at', 'desc')->whereBetween('date_generate', [$start_date, $end_date])->with(['asset', 'workOrderStatus', 'maintenanceType', 'scheduleMaintenance'])->with(['workOrderStatus'])->get() as $workOrder) {
                array_push($ids, $workOrder->id);
                array_push($data['work_orders'], $workOrder);
            }

            $userGroups = $userTechnical->userGroups()->get();
            foreach ($userGroups as $key => $userGroup) {
                foreach ($userGroup->workOrders()->whereNotIn('work_orders.id', $ids)->orderBy('created_at', 'desc')->whereBetween('date_generate', [$start_date, $end_date])->with(['asset', 'workOrderStatus', 'maintenanceType', 'scheduleMaintenance'])->with(['workOrderStatus'])->get() as $workOrder) {
                    array_push($ids, $workOrder->id);
                    array_push($data['work_orders'], $workOrder);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Show work orders',
                'data' => $data['work_orders'],
            ], 200);
    }

    public function workOrder()
    {   
        $data['page_title'] = 'Work Order ' . Auth::guard('user-technical')->user()->name;
        $data['date'] = date('Y-m-d');
        $data['month'] = date('Y-m');
        $data['year'] = date('Y');
        $ids = [];
        $data['work_orders'] = [];
        $userTechnical = Auth::guard('user-technical')->user();
        foreach ($userTechnical->workOrders()->whereNotIn('work_orders.id', $ids)->orderBy('created_at', 'desc')->whereBetween('date_generate', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->with(['workOrderStatus'])->get() as $workOrder) {
                array_push($ids, $workOrder->id);
                array_push($data['work_orders'], $workOrder);
        }

        $userGroups = Auth::guard('user-technical')->user()->userGroups()->get();
        foreach ($userGroups as $key => $userGroup) {
            foreach ($userGroup->workOrders()->whereNotIn('work_orders.id', $ids)->orderBy('created_at', 'desc')->whereBetween('date_generate', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->with(['workOrderStatus'])->get() as $workOrder) {
                    array_push($ids, $workOrder->id);
                    array_push($data['work_orders'], $workOrder);
            }
        }

        return view('user-technicals.work-orders.index', $data);
    }

    public function editWorkOrder($id)
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
        $data['schedule_maintenances'] = ScheduleMaintenance::get();
        $data['tasks'] = Task::get();
        $data['task_groups'] = TaskGroup::get();
        $data['user_groups'] = UserGroup::get();
        $data['user_technicals'] = UserTechnical::get();
        $data['work_order'] = WorkOrder::findOrFail($id);

        return view('user-technicals.work-orders.edit', $data);
    }

    public function updateWorkOrder(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'work_order_status_id' => ['required'],
            'description' => ['nullable', 'min:5'],
            'actual_completion_date' => ['required'],
            'completion_notes' => ['required'],
            'images.*' => ['mimes:jpeg,png,jpg,gif,svg', 'max:10000', 'nullable'],
        ]);

        $work_order = WorkOrder::findOrFail($id);
        $work_order->name = $request->get('name');
        $work_order->work_order_status_id = $request->get('work_order_status_id');
        $work_order->description = $request->get('description');
        $work_order->actual_completion_date = $request->get('actual_completion_date');
        $work_order->completion_notes = $request->get('completion_notes');

        $work_order->save();

        $images = [];

        // Delete File
        $ids = $request->get('prev_images') ?? [0];
        $prev_images = Image::where('work_order_id', $work_order->id)->whereNotIn('id', $ids)->get();
        foreach ($prev_images as $image) {
            $file_path = public_path('img/work-orders/'.$image->name);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }

            $image->delete();
        }

        // check document file
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) { 
                $name = $image->getClientOriginalName();

                // check duplicate name
                $i = 1;
                while(file_exists('img/work-orders/'.$name))
                {           
                    $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)."($i).".$image->getClientOriginalExtension();
                    $i++;
                }
                $destinationPath = public_path('img/work-orders/');
                $image->move($destinationPath, $name);
                
                //set calibration data
                $images[] = [
                    'name' => $name ?? null,
                    'work_order_id' => $work_order->id
                ];
            }

            //save calibration
            $work_order->images()->insert($images);
        }

        // Tasks
        foreach ($work_order->reportTaskWorkOrders as $task) {
            if ($task->status != $request->get($task->id)) {
                $task->user_technical_id = Auth::guard('user-technical')->user()->id;
            }
            $task->status = $request->get($task->id) ? true : false;
            $task->save();
        }

         // Change Material
         if ($request->get('prev_material')) {
            $report_asset_material = [];
            foreach ($request->get('prev_material') as $key => $prev_material) {
                $report_asset_material = [
                    'prev_material' => $request->get('prev_material')[$key],
                    'new_material' => $request->get('new_material')[$key],
                    'remarks' => $request->get('remarks')[$key],
                    'work_order_id' => $request->get('work_order_id')[$key],
                ];

                $this->changeMaterial($report_asset_material);
            }
        }

        return redirect()->route('user-technical.work-order')->with(['success' => 'Work Order updated successfully!']);
    }

    public function changeMaterial($data)
    {
        $prev_material = AssetMaterial::where('id', $data['prev_material'])->first();;

        $material = Material::where('id', $data['new_material'])->first();
        $asset_material = [
            'material_name' => $material->name,
            'purchase_at' => $material->purchase_at,
            'purchase_price' => $material->purchase_price,
            'description' => $material->description,
            'model' => $material->model,
            'brand' => $material->brand,
            'type_id' => $material->type_id,
            'asset_id' => $prev_material->asset_id,
            'bom_id' => $prev_material->bom_id,
            'material_id' => $material->id,
        ];

        if ($prev_material->material_id != $material->id) {
            // Add material to asset material
            $current_material = AssetMaterial::insertGetId($asset_material);

            // delete prev material
            $prev_material->update(['asset_id' => null, 'bom_id' => null]);

            // create history change
            $reportAssetMaterial = new ReportAssetMaterial();
            $reportAssetMaterial->work_order_id = $data['work_order_id'];
            $reportAssetMaterial->remarks = $data['remarks'];
            $reportAssetMaterial->prev_material = $data['prev_material'];
            $reportAssetMaterial->current_material = $current_material;
            $reportAssetMaterial->save();
        }
    }

    public function createModal()
    {
        return view('user-technicals.create-modal');
    }

    public function getUserTechnicals()
    {
        $user_technicals = UserTechnical::orderBy('created_at', 'asc')->get();

        return response()->json(['status' => '200', 'data' => $user_technicals]);
    }

    public function getUserTechnical(Request $request)
    {
        if ($request->get('username')) {
            $user_technical = UserTechnical::where('username', $request->get('username'))->first();
        } elseif ($request->get('id')) {
            $user_technical = UserTechnical::where('id', $request->get('id'))->first();
        } else {
            $user_technical = null;
        }

        return response()->json(['status' => '200', 'data' => $user_technical]);
    }

    public function showUserGroup($id)
    {
        $data['user_technical_group'] = UserGroup::findOrFail($id);

        return view('user-technical-groups.show', $data);
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
