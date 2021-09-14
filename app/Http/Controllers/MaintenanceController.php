<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:maintenance-create', ['only' => ['create','store']]);
        $this->middleware('permission:maintenance-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:maintenance-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
    }

    public function create()
    {
        return view('components.create-maintenance');
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
                'asset_id' => ['required']
            ]);

            $maintenance = new Maintenance();

            $maintenance->title = $request->get('title');
            $maintenance->description = $request->get('description');
            $maintenance->asset_id = $request->get('asset_id');

            $maintenance->save();
            return response()->json(['status' => '200']);
        } catch (\Throwable $th) {
            return response()->json(['status' => '403', 'msg' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $data['maintenance'] = Maintenance::findOrFail($id);
        return view('components.edit-maintenance', $data); 
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
                'asset_id' => ['required']
            ]);

            $maintenance = Maintenance::findOrFail($id);

            $maintenance->title = $request->get('title');
            $maintenance->description = $request->get('description');
            $maintenance->asset_id = $request->get('asset_id');

            $maintenance->save();
            return response()->json(['status' => '200']);
        } catch (\Throwable $th) {
            return response()->json(['status' => '403', 'msg' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $maintenance = Maintenance::findOrFail($id)->delete();
            return response()->json(['status' => '200', 'msg' => $maintenance]);
        } catch (\Throwable $th) {
            return response()->json(['status' => '403', 'msg' => $th->getMessage()]);
        }
    }
}
