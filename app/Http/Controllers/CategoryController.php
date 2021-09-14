<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category-list', ['only' => 'index']);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Category';
        $data['categories'] = Category::orderBy('id', 'desc')->get();

        return view('categories.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Category';

        return view('categories.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[\pL\s\-]+$/u', 'unique:categories,name'],
            'description' => ['nullable', 'min:3']
        ]);

        $category = new Category();
        $category->name = $request->get('name');
        $category->description = $request->get('description');

        $category->save();

        return redirect()->route('categories.index')->with(['success' => 'Category added successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Category';
        $data['category'] = Category::findOrFail($id);

        return view('categories.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^[\pL\s\-]+$/u', 'unique:categories,name,' . $id],
            'description' => ['nullable', 'min:3']
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->get('name');
        $category->description = $request->get('description');

        $category->save();

        return redirect()->route('categories.index')->with(['success' => 'Category edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            Asset::where('category_id', $id)->update(['category_id' => null]);
            Category::findOrFail($id)->delete();
        });
        
        Session::flash('success', 'Category deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
