<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Material;
use File;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:type-list', ['only' => 'index']);
        $this->middleware('permission:type-create', ['only' => ['create','store']]);
        $this->middleware('permission:type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:type-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Type';
        $data['types'] = Type::orderBy('id', 'desc')->get();

        return view('types.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Type';

        return view('types.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[\pL\s\-]+$/u', 'unique:types,name'],
            'description' => ['nullable', 'min:3'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $type = new Type();
        $type->name = $request->get('name');
        $type->description = $request->get('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/types/');
            $image->move($destinationPath, $name);
            $type->image = $name;
        }

        $type->save();

        return redirect()->route('types.index')->with(['success' => 'Type added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Type';
        $data['type'] = Type::findOrFail($id);

        return view('types.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[\pL\s\-]+$/u', 'unique:types,name,' . $id],
            'description' => ['nullable', 'min:3'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $type = Type::findOrFail($id);
        $type->name = $request->get('name');
        $type->description = $request->get('description');

        if ($request->hasFile('image')) {
            // Delete Img
            if ($type->image) {
                $image_path = public_path('img/types/'.$type->image);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/types/');
            $image->move($destinationPath, $name);
            $type->image = $name;
        }

        $type->save();

        return redirect()->route('types.index')->with(['success' => 'Type updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $type = Type::findOrFail($id);

            if ($type->image) {
                $image_path = public_path('img/types/'.$type->image); // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            Asset::where('type_id', $id)->update(['type_id' => null]);
            Material::where('type_id', $id)->update(['type_id' => null]);
            $type->delete();
        });
        
        Session::flash('success', 'Type deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
