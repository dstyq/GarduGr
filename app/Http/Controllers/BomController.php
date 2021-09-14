<?php

namespace App\Http\Controllers;

use App\Models\AssetMaterial;
use App\Models\Bom;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BomController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bom-list', ['only' => 'index']);
        $this->middleware('permission:bom-create', ['only' => ['create','store']]);
        $this->middleware('permission:bom-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bom-detail', ['only' => 'show']);
        $this->middleware('permission:bom-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Bill Of Materials';
        $data['boms'] = Bom::orderBy('id', 'desc')->get();

        return view('boms.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Bill Of Materials';
        $data['materials'] = Material::get();

        return view('boms.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'min:5'],
            'materials' => ['required'],
        ]);

        $bom = new Bom();
        $bom->name = $request->get('name');
        $bom->description = $request->get('description');

        $bom->save();
        $bom->materials()->attach($request->get('materials'));

        return redirect()->route('boms.index')->with(['success' => 'Bom saved successfully!']);
    }

    public function show($id)
    {
        $data['bom'] = Bom::findOrFail($id);
        $data['materials'] = $data['bom']->materials->all();

        return view('boms.show', $data);
    }

    public function showMaterial($assetId, $bomId)
    {
        $data['materials'] = AssetMaterial::where('bom_id', $bomId)->where('asset_id', $assetId)->get();

        return view('boms.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Bom';
        $data['materials'] = Material::get();
        $data['bom'] = Bom::findOrFail($id);

        return view('boms.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'min:5'],
            'materials' => ['required'],
        ]);

        $bom = Bom::findOrFail($id);
        $bom->name = $request->get('name');
        $bom->description = $request->get('description');

        $bom->save();
        $bom->materials()->sync($request->get('materials'));

        return redirect()->route('boms.index')->with(['success' => 'Bom updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $bom = Bom::findOrFail($id);
            $bom->materials()->detach();
            $bom->assets()->detach();
            $bom->delete();
        });
        
        Session::flash('success', 'Bom deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
