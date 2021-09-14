<?php

namespace App\Http\Controllers;

use App\Models\Asset;
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
        $data['location_categories'] = LocationCategory::orderBy('id', 'desc')->get();

        return view('locations.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:locations,name'],
            'country' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:56', 'min:4'],
            'province' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u'],
            'city' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u'],
            'address' => ['required', 'min:5', 'max:126', 'string', 'unique:locations,address'],
            'postal_code' => ['required'],
            'latitude' => ['nullable', 'regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$^'],
            'longitude' => ['nullable', 'regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$^'],
            'location_category_id' => ['required'],
        ]);

        $location = new Location();
        $location->name = $request->get('name');
        $location->country = $request->get('country');
        $location->province = $request->get('province');
        $location->city = $request->get('city');
        $location->address = $request->get('address');
        $location->postal_code = $request->get('postal_code');
        $location->latitude = $request->get('latitude');
        $location->longitude = $request->get('longitude');
        $location->location_category_id = $request->get('location_category_id');

        $location->save();

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
        $data['location_categories'] = LocationCategory::orderBy('id', 'desc')->get();
        $data['location'] = Location::findOrFail($id);

        return view('locations.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:location_categories,name,' . $id],            
            'country' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u', 'max:56', 'min:4'],
            'province' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u'],
            'city' => ['required', 'string', 'regex:/^[\pL\s\-]+$/u'],
            'address' => ['required', 'min:5', 'max:126', 'string', 'unique:locations,address,' . $id],
            'postal_code' => ['required'],
            'latitude' => ['nullable', 'regex:^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$^'],
            'longitude' => ['nullable', 'regex:^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$^'],
            'location_category_id' => ['required'],
        ]);

        $location = Location::findOrFail($id);
        $location->name = $request->get('name');
        $location->country = $request->get('country');
        $location->province = $request->get('province');
        $location->city = $request->get('city');
        $location->address = $request->get('address');
        $location->postal_code = $request->get('postal_code');
        $location->latitude = $request->get('latitude');
        $location->longitude = $request->get('longitude');
        $location->location_category_id = $request->get('location_category_id');

        $location->save();

        return redirect()->route('locations.index')->with(['success' => 'Location updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            Asset::where('location_id', $id)->update(['location_id' => null]);
            Location::where('id', $id)->delete();
        });

        Session::flash('success', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
