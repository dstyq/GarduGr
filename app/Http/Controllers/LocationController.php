<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\HistoryLog;
use App\Models\Location;
use App\Models\LocationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:location-list', ['only' => 'index']);
        $this->middleware('permission:location-create', ['only' => ['create','store']]);
        $this->middleware('permission:location-detail', ['only' => 'show']);
        $this->middleware('permission:location-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:location-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Location';
        $data['locations'] = Location::orderBy('id', 'desc')->get();

        return view('locations.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Location';
        $data['locations'] = Location::whereNull('parent_id')->get();

        return view('locations.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:locations,name'],
            'latitude' => ['nullable', 'regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$^'],
            'longitude' => ['nullable', 'regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$^'],
            'parent_location' => ['nullable'],
        ]);

        $location = new Location();
        $location->name = $request->get('name');
        $location->country = 'N/A';
        $location->province = 'N/A';
        $location->city = 'N/A';
        $location->postal_code = 'N/A';
        $location->latitude = $request->get('latitude');
        $location->longitude = $request->get('longitude');
        $location->parent_id = $request->get('parent_location');

        $location->save();

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Add Location';
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        return redirect()->route('locations.index')->with(['success' => 'Location added successfully!']);
    }

    public function show($id)
    {
        $data['page_title'] = 'Detail Location';
        $data['location'] = Location::findOrFail($id);

        return view('locations.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Location';
        $data['locations'] = Location::whereNull('parent_id')->get();
        $data['location'] = Location::findOrFail($id);

        return view('locations.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:location_categories,name,' . $id],            
            'latitude' => ['nullable', 'regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$^'],
            'longitude' => ['nullable', 'regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$^'],
            'parent_location' => ['nullable'],
        ]);

        $location = Location::findOrFail($id);
        $location->name = $request->get('name');
        $location->country = 'N/A';
        $location->province = 'N/A';
        $location->city = 'N/A';
        $location->postal_code = 'N/A';
        $location->latitude = $request->get('latitude');
        $location->longitude = $request->get('longitude');
        $location->parent_id = $request->get('parent_location');

        $location->save();

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Update Location';
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        return redirect()->route('locations.index')->with(['success' => 'Location updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete Location';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
            // Asset::where('location_id', $id)->update(['location_id' => null]);
            Location::where('id', $id)->delete();
        });

        Session::flash('success', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
