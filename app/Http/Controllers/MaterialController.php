<?php

namespace App\Http\Controllers;

use App\Models\AssetMaterial;
use App\Models\Material;
use App\Models\ReportAssetMaterial;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:material-list', ['only' => 'index']);
        $this->middleware('permission:material-create', ['only' => ['create','store']]);
        $this->middleware('permission:material-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:material-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Material';
        $data['materials'] = Material::orderBy('id', 'desc')->get();

        return view('materials.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Material';
        $data['types'] = Type::get();

        return view('materials.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'purchase_at' => ['required', 'date_format:Y-m-d'],
            'purchase_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'description' => ['nullable', 'min:5'],
            'model' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'type' => ['required'],
        ]);

        $material = new Material();

        $material->name = $request->get('name');
        $material->purchase_at = $request->get('purchase_at');
        $material->purchase_price = $request->get('purchase_price');
        $material->description = $request->get('description');
        $material->model = $request->get('model');
        $material->brand = $request->get('brand');
        $material->type_id = $request->get('type');

        $material->save();

        return redirect()->route('materials.index')->with(['success' => 'Material added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Material';
        $data['types'] = Type::get();
        $data['material'] = Material::findOrFail($id);

        return view('materials.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'purchase_at' => ['required', 'date_format:Y-m-d'],
            'purchase_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'description' => ['nullable', 'min:5'],
            'model' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'type' => ['required'],
        ]);

        $material = Material::findOrFail($id);

        $material->name = $request->get('name');
        $material->purchase_at = $request->get('purchase_at');
        $material->purchase_price = $request->get('purchase_price');
        $material->description = $request->get('description');
        $material->model = $request->get('model');
        $material->brand = $request->get('brand');
        $material->type_id = $request->get('type');

        $material->save();

        return redirect()->route('materials.index')->with(['success' => 'Material updated successfully!']);
    }

    public function destroy($id)
    {
        // DB::transaction(function () use ($id) {
        //     // Delete material
        //     $material = Material::findOrFail($id);
        //     $material->boms()->detach();
        //     $material->delete();
        // });

        DB::transaction(function () use ($id) {
            $material = Material::findOrFail($id);
            $material->boms()->detach();
            $material->delete();
        });
        
        Session::flash('success', 'Departement deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function changeModal($id)
    {
        $data['materials'] = Material::get();
        $data['material'] = AssetMaterial::where('id', $id)->first();
        return view('user-technicals.work-orders.modal-change-material', $data);
    }
}
