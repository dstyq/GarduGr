<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:task-group-list', ['only' => 'index']);
        $this->middleware('permission:task-group-create', ['only' => ['create','store']]);
        $this->middleware('permission:task-group-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:task-group-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Task Group';
        $data['task_groups'] = TaskGroup::orderBy('id', 'desc')->get();

        return view('task-groups.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Task Group';
        $data['tasks'] = Task::get();

        return view('task-groups.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'min:5'],
            'tasks' => ['required'],
        ]);

        $task_group = new TaskGroup();
        $task_group->name = $request->get('name');
        $task_group->description = $request->get('description');
        $task_group->from = $request->get('from');

        $task_group->save();
        $task_group->tasks()->attach($request->get('tasks'));

        if ($request->get('from') == 'task_group') {
            return redirect()->route('task-groups.index')->with(['success' => 'Task Group saved successfully!']);
        }else {
            return response()->json(['status' => '200']);            
        }
    }

    public function show($id)
    {
        $data['task_group'] = TaskGroup::findOrFail($id);

        return view('task-groups.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Task Group';
        $data['tasks'] = Task::get();
        $data['task_group'] = TaskGroup::findOrFail($id);

        return view('task-groups.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'min:5'],
            'tasks' => ['required'],
        ]);

        $task_group = TaskGroup::findOrFail($id);
        $task_group->name = $request->get('name');
        $task_group->description = $request->get('description');

        $task_group->save();
        $task_group->tasks()->sync($request->get('tasks'));

        return redirect()->route('task-groups.index')->with(['success' => 'Task Group updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $task_group = TaskGroup::findOrFail($id);
            $task_group->tasks()->detach();
            $task_group->scheduleMaintenances()->detach();
            $task_group->workOrders()->detach();
            $task_group->delete();
        });
        
        Session::flash('success', 'Task Group deleted successfully!');
        return response()->json(['status' => '200']);
    }
    
    public function createModal()
    {
        $data['tasks'] = Task::get();
        return view('task-groups.create-modal', $data);
    }

    public function getTaskGroups()
    {
        $task_groups = TaskGroup::orderBy('created_at', 'asc')->get();

        return response()->json(['status' => '200', 'data' => $task_groups]);
    }
}
