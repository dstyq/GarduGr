<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\HistoryLog;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CctvController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cctv-list', ['only' => 'index']);
        $this->middleware('permission:cctv-create', ['only' => ['create','store']]);
        $this->middleware('permission:cctv-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:cctv-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Device Management';
        $data['cctv'] = Cctv::orderBy('id', 'desc')->get();

        return view('cctv.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Device';
        $data['locations'] = Location::whereNotNull('parent_id')->get();

        return view('cctv.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'link' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$^'],
            'longitude' => ['nullable', 'regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$^'],
            'location' => ['required'],
        ]);

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Add Device';
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        $cctv = new Cctv();
        $cctv->name = $request->get('name');
        $cctv->link = $request->get('link');
        $cctv->description = $request->get('description');
        $cctv->address = $request->get('address');
        $cctv->latitude = $request->get('latitude');
        $cctv->longitude = $request->get('longitude');
        $cctv->location_id = $request->get('location');

        $cctv->save();

        return redirect()->route('device.index')->with(['success' => 'Cctv added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Device';
        $data['cctv'] = Cctv::findOrFail($id);

        return view('cctv.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'link' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$^'],
            'longitude' => ['nullable', 'regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$^'],
        ]);

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Update Device';
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        $cctv = Cctv::findOrFail($id);
        $cctv->name = $request->get('name');
        $cctv->link = $request->get('link');
        $cctv->description = $request->get('description');
        $cctv->address = $request->get('address');
        $cctv->latitude = $request->get('latitude');
        $cctv->longitude = $request->get('longitude');

        $cctv->save();

        return redirect()->route('device.index')->with(['success' => 'Cctv edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete Device';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            Cctv::where('id', $id)->delete();
        });

        Session::flash('success', 'CCTV deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
