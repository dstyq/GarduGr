<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:task-list', ['only' => 'index']);
        $this->middleware('permission:task-create', ['only' => ['create','store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Task';
        $data['tasks'] = Task::orderBy('id', 'desc')->get();

        return view('tasks.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Task';

        return view('tasks.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => ['required', 'string', 'unique:tasks,task'],
            'description' => ['nullable', 'min:3'],
            'time_estimate' => ['nullable', 'integer']
        ]);

        $task = new Task();
        $task->task = $request->get('task');
        $task->description = $request->get('description');
        $task->time_estimate = $request->get('time_estimate');
        $task->from = $request->get('from');

        $task->save();

        if ($request->get('from') == 'task') {
            return redirect()->route('tasks.index')->with(['success' => 'Task added successfully!']);
        }else {
            return response()->json(['status' => '200', 'data' => $task]);
        }
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Task';
        $data['task'] = Task::findOrFail($id);

        return view('tasks.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => ['required', 'string', 'unique:tasks,task,' . $id],
            'description' => ['nullable', 'min:3'],
            'time_estimate' => ['nullable', 'integer']
        ]);

        $task = Task::findOrFail($id);
        $task->task = $request->get('task');
        $task->description = $request->get('description');
        $task->time_estimate = $request->get('time_estimate');

        $task->save();

        return redirect()->route('tasks.index')->with(['success' => 'Task edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $task = Task::findOrFail($id);
            $task->taskGroups()->detach();
            $task->scheduleMaintenances()->detach();
            $task->workOrders()->detach();
            $task->delete();
        });
        
        Session::flash('success', 'Task deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function createModal()
    {
        return view('tasks.create-modal');
    }

    public function getTasks()
    {
        $tasks = Task::orderBy('created_at', 'asc')->get();

        return response()->json(['status' => '200', 'data' => $tasks]);
    }
}
