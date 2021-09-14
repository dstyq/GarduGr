<?php

namespace App\Http\Controllers;

use File;
use App\Models\Asset;
use App\Models\AssetMaterial;
use App\Models\Bom;
use App\Models\Category;
use App\Models\Document;
use App\Models\Location;
use App\Models\Material;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:asset-list', ['only' => 'index']);
        $this->middleware('permission:asset-create', ['only' => ['create','store']]);
        $this->middleware('permission:asset-detail', ['only' => 'show']);
        $this->middleware('permission:asset-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:asset-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Asset';
        $data['asset_count'] = Asset::orderBy('id', 'desc')->count();

        return view('assets.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = 'Add Asset';
        $data['categories'] = Category::get();
        $data['types'] = Type::get();
        $data['locations'] = Location::get();
        $data['assets'] = Asset::get();
        $data['boms'] = Bom::get();
        
        $asset_count = $data['assets']->count();
        $data['code'] = $this->generateCode($asset_count);

        while (Asset::where('code', $data['code'])->get()->count() > 0) {
           $data['code'] = $this->generateCode($asset_count++);
        }

        if ($request->has('parent')) {
            $data['parent'] = Asset::find($request->get('parent'));
            if ($data['parent'] == null) {
                return redirect()->route('assets.index')->with(['failed' => 'Id parent not found!']);
            }
        }

        return view('assets.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:assets,code'],
            'name' => ['required', 'string'],
            'purchase_at' => ['required', 'date_format:Y-m-d'],
            'purchase_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'description' => ['nullable', 'min:5'],
            'status' => ['required', 'in:1,0'],
            'model' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'nullable'],
            'brand' => ['required', 'string'],
            'category_id' => ['required'],
            'type_id' => ['required'],
            'location_id' => ['required'],
            'parent_id' => ['required'],
            'filename.*' => ['mimes:pdf,word,docx,ppt,pptx,csv,xlsx,jpeg,png,jpg,gif,svg', 'max:15000', 'nullable'],
            'link.*' => ['nullable'],
            'bom_id' => ['nullable'],
        ]);

        // Set data for asset
        $data['code'] = $request->get('code');
        $data['name'] = $request->get('name');
        $data['purchase_at'] = $request->get('purchase_at');
        $data['purchase_price'] = $request->get('purchase_price');
        $data['description'] = $request->get('description');
        $data['status'] = $request->get('status');
        $data['model'] = $request->get('model');
        $data['brand'] = $request->get('brand');
        $data['category_id'] = $request->get('category_id');
        $data['type_id'] = $request->get('type_id');
        $data['location_id'] = $request->get('location_id');
        $data['parent_id'] = ($request->get('parent_id') == 0) ? null : $request->get('parent_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/assets/');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        // save asset and get return id
        $asset = Asset::create($data);
        $asset->boms()->attach($request->get('bom_id'));

        // check supporting document file
        if ($request->hasFile('filename')) {
            $documents = [];

            foreach ($request->file('filename') as $file) { 
                $name = $file->getClientOriginalName();

                // check duplicate name
                $i = 1;
                while(file_exists('docs/'.$name))
                {           
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)."($i).".$file->getClientOriginalExtension();
                    $i++;
                }
                $destinationPath = public_path('docs');
                $file->move($destinationPath, $name);
                
                //set calibration data
                $documents[] = [
                    'filename' => $name ?? null,
                    'asset_id' => $asset->id,
                    'type' => 'file'
                ];
            }

            //save calibration
            $asset->documents()->insert($documents);
        }

        // check supporting link
        if ($request->get('link')) {
            $link = [];

            for ($i = 0; $i < count($request->get('link')) - 1; $i++) { 
                $link[] = [
                    'filename' => $request->get('link')[$i],
                    'asset_id' => $asset->id,
                    'type' => 'link'
                ];
            }

            //save calibration
            $asset->documents()->insert($link);
        }

        // save asset material        
        if ($request->get('bom_id')) {
            $material_id = [];
            $bom_id = [];

            foreach ($request->get('bom_id') as $id) {
                $boms = Bom::where('id', $id)->first();
                foreach ($boms->materials as $material) {
                    if (!in_array($material->id, $material_id)) {
                        array_push($bom_id, $id);
                        array_push($material_id, $material->id);
                    }
                }
            }

            $asset_materials = [];

            foreach ($material_id as $index => $id) {
                $material = Material::where('id', $id)->first();
                $asset_materials[] = [
                    'material_name' => $material->name,
                    'purchase_at' => $material->purchase_at,
                    'purchase_price' => $material->purchase_price,
                    'description' => $material->description,
                    'model' => $material->model,
                    'brand' => $material->brand,
                    'type_id' => $material->type_id,
                    'asset_id' => $asset->id,
                    'bom_id' => $bom_id[$index],
                    'material_id' => $material->id,
                ];
            }

            AssetMaterial::insert($asset_materials);
        }

        return redirect()->route('assets.index')->with(['success' => 'Asset added successfully!']);
    }

    public function show($id)
    {
        $data['page_title'] = 'Detail Asset';
        $data['asset'] = Asset::with(['parent', 'children'])->findOrFail($id);

        return view('assets.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Asset';
        $data['categories'] = Category::get();
        $data['types'] = Type::get();
        $data['locations'] = Location::get();
        $data['boms'] = Bom::get();
        $data['assets'] = Asset::where('parent_id', '!=', $id)->orWhereNull('parent_id')->get();
        $data['asset'] = Asset::findOrFail($id);

        return view('assets.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:assets,code,' . $id],
            'name' => ['required', 'string'],
            'purchase_at' => ['required', 'date_format:Y-m-d'],
            'purchase_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'description' => ['nullable', 'min:5'],
            'status' => ['required', 'in:1,0'],
            'model' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'nullable'],
            'brand' => ['required', 'string'],
            'category_id' => ['required'],
            'type_id' => ['required'],
            'location_id' => ['required'],
            'parent_id' => ['required'],
            'filename.*' => ['mimes:pdf,word,docx,ppt,pptx,csv,xlsx,jpeg,png,jpg,gif,svg', 'max:15000', 'nullable'],
            'bom_id' => ['nullable'],
            'link.*' => ['nullable'],
        ]);

        $asset = Asset::findOrFail($id);

        // Set data for asset
        $data['code'] = $request->get('code');
        $data['name'] = $request->get('name');
        $data['purchase_at'] = $request->get('purchase_at');
        $data['purchase_price'] = $request->get('purchase_price');
        $data['description'] = $request->get('description');
        $data['status'] = $request->get('status');
        $data['model'] = $request->get('model');
        $data['brand'] = $request->get('brand');
        $data['category_id'] = $request->get('category_id');
        $data['type_id'] = $request->get('type_id');
        $data['location_id'] = $request->get('location_id');
        $data['parent_id'] = ($request->get('parent_id') == 0) ? null : $request->get('parent_id');

        if ($request->hasFile('image')) {
            // Delete Img
            if ($asset->image) {
                $image_path = public_path('img/assets/'.$asset->image);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('img/assets/');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        $asset->update($data);
        // save asset material        
        if ($request->get('bom_id')) {
            $material_id = [];
            $bom_id = [];

            foreach ($request->get('bom_id') as $id) {
                $boms = Bom::where('id', $id)->first();
                foreach ($boms->materials as $material) {
                    if (!in_array($material->id, $material_id)) {
                        array_push($bom_id, $id);
                        array_push($material_id, $material->id);
                    }
                }
            }

            $asset_materials = [];
            $materials_ids = AssetMaterial::where('asset_id', $asset->id)->pluck('material_id')->all();
            foreach ($material_id as $index => $id) {
                $material = Material::where('id', $id)->first();
                if (!in_array($material->id, $materials_ids)) {
                    $asset_materials[] = [
                        'material_name' => $material->name,
                        'purchase_at' => $material->purchase_at,
                        'purchase_price' => $material->purchase_price,
                        'description' => $material->description,
                        'model' => $material->model,
                        'brand' => $material->brand,
                        'type_id' => $material->type_id,
                        'asset_id' => $asset->id,
                        'bom_id' => $bom_id[$index],
                        'material_id' => $material->id,
                    ];
                }
            }

            AssetMaterial::insert($asset_materials);
            $asset->boms()->sync($request->get('bom_id'));
        }
        
        $documents = [];

        // Delete File
        $ids = $request->get('documents') ?? [0];
        $asset_deletes = Document::where('asset_id', $asset->id)->where('type', 'file')->whereNotIn('id', $ids)->get();
        foreach ($asset_deletes as $asset_delete) {
            $file_path = public_path('docs/'.$asset_delete->filename);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }

            $asset_delete->delete();
        }

        // check document file
        if ($request->hasFile('filename')) {

            foreach ($request->file('filename') as $file) { 
                $name = $file->getClientOriginalName();

                // check duplicate name
                $i = 1;
                while(file_exists('docs/'.$name))
                {           
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)."($i).".$file->getClientOriginalExtension();
                    $i++;
                }
                $destinationPath = public_path('docs/');
                $file->move($destinationPath, $name);
                
                //set calibration data
                $documents[] = [
                    'filename' => $name ?? null,
                    'asset_id' => $asset->id,
                    'type' => 'file'
                ];
            }

            //save calibration
            $asset->documents()->insert($documents);
        }

        // Delete supporting link
        $link_deletes = Document::where('asset_id', $asset->id)->where('type', 'link')->get();
        foreach ($link_deletes as $link_delete) {
            $link_delete->delete();
        }

        // check supporting link
        if ($request->get('link')) {
            $link = [];

            for ($i = 0; $i < count($request->get('link')) - 1; $i++) { 
                if ($request->get('link')[$i] != null) {
                    $link[] = [
                        'filename' => $request->get('link')[$i],
                        'asset_id' => $asset->id,
                        'type' => 'link'
                    ];
                }
            }

            //save calibration
            $asset->documents()->insert($link);
        }

        return redirect()->route('assets.index')->with(['success' => 'Asset updated successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            // Delete document
            $asset_documents = Document::where('asset_id', $id)->get();
            foreach ($asset_documents as $asset_document) {
                $file_path = public_path('docs/'.$asset_document->filename);
                if (File::exists($file_path)) {
                    File::delete($file_path);
                }

                $asset_document->delete();
            }

            // Delete Asset
            $asset = Asset::findOrFail($id);

            // Update Child
            if ($asset->parent_id) {
                Asset::where('parent_id', $id)->update(['parent_id' => $asset->parent_id]);
            } else {
                Asset::where('parent_id', $id)->update(['parent_id' => null]);
            }

            if ($asset->image) {
                $image_path = public_path('img/assets/'.$asset->image);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            // Delete Asset material
            AssetMaterial::where('asset_id', $id)->delete();
            
            $asset->boms()->detach();
            $asset->maintenances()->delete();
            $asset->delete();
        });

        Session::flash('success', 'Asset deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function generateCode($number)
    {
        $char = 'A';
        $number = $number;
        
        // For adjust a character
        if ($number >= 98) {
            $plus = 0;
            while ($number - 100 >= 0) {
                $plus++;
                $number -= 100;
            }
            $number++;

            // For make a code no more than 2 digits
            if (strlen($number) > 2) {
                $number--;
            }

            for ($z=0; $z < $plus; $z++) { 
                $char++;
            }
        } else {
            $number++;
        }

        return "#$char".sprintf("%02s", $number);
    }
}