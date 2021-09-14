<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationCategory;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LocationCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:location-category-list', ['only' => 'index']);
        $this->middleware('permission:location-category-create', ['only' => ['create','store']]);
        $this->middleware('permission:location-category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:location-category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Location Category';
        $data['location_categories'] = LocationCategory::orderBy('id', 'desc')->get();

        return view('location-categories.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Location Category';

        return view('location-categories.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[\pL\s\-]+$/u', 'unique:location_categories,name'],
            'description' => ['nullable', 'min:3'],
            'icon' => ['required','image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $location_category = new LocationCategory();
        $location_category->name = $request->get('name');
        $location_category->description = $request->get('description');

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $name = time() . '.' . $icon->getClientOriginalExtension();
            $destinationPath = public_path('img/location-categories/');
            $icon->move($destinationPath, $name);
            $location_category->icon = $name;
        }

        $location_category->save();

        return redirect()->route('location-categories.index')->with(['success' => 'Location Category added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Location Category';
        $data['location_category'] = LocationCategory::findOrFail($id);

        return view('location-categories.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[\pL\s\-]+$/u', 'unique:location_categories,name,' . $id],
            'description' => ['nullable', 'min:3'],
            'icon' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $location_category = LocationCategory::findOrFail($id);
        $location_category->name = $request->get('name');
        $location_category->description = $request->get('description');

        if ($request->hasFile('icon')) {
            // Delete Img
            if ($location_category->icon) {
                $icon_path = public_path('img/location-categories/'.$location_category->icon);
                if (File::exists($icon_path)) {
                    File::delete($icon_path);
                }
            }

            $icon = $request->file('icon');
            $name = time() . '.' . $icon->getClientOriginalExtension();
            $destinationPath = public_path('img/location-categories/');
            $icon->move($destinationPath, $name);
            $location_category->icon = $name;
        }

        $location_category->save();

        return redirect()->route('location-categories.index')->with(['success' => 'Location Category updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $location_category = LocationCategory::findOrFail($id);

            if ($location_category->icon) {
                $icon_path = public_path('img/location-categories/'.$location_category->icon); // Value is not URL but directory file path
                if (File::exists($icon_path)) {
                    File::delete($icon_path);
                }
            }

            Location::where('location_category_id', $id)->update(['location_category_id' => null]);
            $location_category->delete();
        });
        
        Session::flash('success', 'Type deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
