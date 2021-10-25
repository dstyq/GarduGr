<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use App\Models\Location;
use App\Models\AccessDoor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccessDoorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access-door-list', ['only' => 'index']);
        $this->middleware('permission:access-door-create', ['only' => ['create','store']]);
        $this->middleware('permission:access-door-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:access-door-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Device Management Access Door';
        $data['access'] = AccessDoor::orderBy('id', 'desc')->get();

        return view('access-door.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Device Access Door';
        $data['locations'] = Location::whereNotNull('parent_id')->get();

        return view('access-door.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'link' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'location' => ['required'],
        ]);

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Add Device Access Door';
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        $acces_door = new AccessDoor();
        $acces_door->name = $request->get('name');
        $acces_door->link = $request->get('link');
        $acces_door->description = $request->get('description');
        $acces_door->address = $request->get('address');
        $acces_door->location_id = $request->get('location');

        $acces_door->save();

        return redirect()->route('access-door.index')->with(['success' => 'Device Acces Door added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Device Access Door';
        $data['locations'] = Location::whereNotNull('parent_id')->get();
        $data['access'] = AccessDoor::findOrFail($id);

        return view('access-door.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'link' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'location' => ['required'],
        ]);

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Update Device Access Door';
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        $acces_door = AccessDoor::findOrFail($id);
        $acces_door->name = $request->get('name');
        $acces_door->link = $request->get('link');
        $acces_door->description = $request->get('description');
        $acces_door->address = $request->get('address');
        $acces_door->location_id = $request->get('location');

        $acces_door->save();

        return redirect()->route('access-door.index')->with(['success' => 'Device Acces Door edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete Device Access Door';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            AccessDoor::where('id', $id)->delete();
        });

        Session::flash('success', 'Device Acces Door deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
