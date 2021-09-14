<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Models\UserTechnical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use function PHPSTORM_META\map;

class UserGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-group-list', ['only' => 'index']);
        $this->middleware('permission:user-group-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-group-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-group-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'User Technical Group';
        $data['user_technical_groups'] = UserGroup::orderBy('id', 'desc')->get();

        return view('user-technical-groups.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add User Technical Group';
        $data['user_technicals'] = UserTechnical::get();

        return view('user-technical-groups.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'min:5'],
            'user_technicals' => ['required'],
        ]);

        $user_group = new UserGroup();
        $user_group->name = $request->get('name');
        $user_group->description = $request->get('description') ?? ' ';
        $user_group->from = $request->get('from');

        $user_group->save();
        $user_group->userTechnicals()->attach($request->get('user_technicals'));

        if ($request->get('from') == 'user_technical_group') {
            return redirect()->route('user-technical-groups.index')->with(['success' => 'User Technical Group saved successfully!']);
        }else {
            return response()->json(['status' => '200', 'data' => $user_group]);
        }
    }

    public function show($id)
    {
        $data['user_technical_group'] = UserGroup::findOrFail($id);

        return view('user-technical-groups.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit User Technical Group';
        $data['user_technicals'] = UserTechnical::get();
        $data['user_technical_group'] = UserGroup::findOrFail($id);

        return view('user-technical-groups.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'min:5'],
            'user_technicals' => ['required'],
        ]);

        $user_group = UserGroup::findOrFail($id);
        $user_group->name = $request->get('name');
        $user_group->description = $request->get('description');

        $user_group->save();
        $user_group->userTechnicals()->sync($request->get('user_technicals'));

        return redirect()->route('user-technical-groups.index')->with(['success' => 'Task Group updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $user_group = UserGroup::findOrFail($id);
            $user_group->userTechnicals()->detach();
            $user_group->workOrders()->detach();
            $user_group->scheduleMaintenances()->detach();
            $user_group->delete();
        });
        
        Session::flash('success', 'User Technical Group deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function createModal()
    {
        $data['user_technicals'] = UserTechnical::get();
        return view('user-technical-groups.create-modal', $data);
    }

    public function getUserTechnicalGroups()
    {
        $user_groups = UserGroup::orderBy('created_at', 'asc')->get();
        $user_groups = $user_groups->map(function ($user_group) {
            $data['id'] = $user_group->id;
            $data['name'] = $user_group->name;
            $data['description'] = $user_group->description;
            $data['from'] = $user_group->from;
            $data['user_count'] = $user_group->userTechnicals()->count();
            $data['users'] = $user_group->userTechnicals()->pluck('username');
            return $data;
        });

        return response()->json(['status' => '200', 'data' => $user_groups]);
    }

    public function getUserTechnicalGroup(Request $request)
    {
        if ($request->get('name')) {
            $user_group = UserGroup::where('name', $request->get('name'))->first();
        }elseif ($request->get('id')) {
            $user_group = UserGroup::where('id', $request->get('id'))->first();
        } else {
            $user_group = null;
        }

        return response()->json(['status' => '200', 'data' => $user_group]);
    }
}