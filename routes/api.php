<?php

use App\Http\Controllers\api\AssetController;
use App\Http\Controllers\api\MapController;
use App\Http\Controllers\api\WorkOrderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserTechnicalController;
use App\Models\AssetMaterial;
use App\Models\Document;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Map
Route::get('cctv', [MapController::class, 'getCctv']);
Route::get('assets', [MapController::class, 'getAssets']);
Route::get('legends', [MapController::class, 'getLegends']);

// Assets
Route::get('assets', [AssetController::class, 'getAssets']);

// Work Orders
Route::post('work-orders', [WorkOrderController::class, 'getWorkOrders']);

Route::get('user-technicals', [UserTechnicalController::class, 'getUserTechnicals']);
Route::get('tasks', [TaskController::class, 'getTasks']);
Route::get('task-groups', [TaskGroupController::class, 'getTaskGroups']);
Route::post('user-technical', [UserTechnicalController::class, 'getUserTechnical']);
Route::get('user-technical-groups', [UserGroupController::class, 'getUserTechnicalGroups']);
Route::post('user-technical-group', [UserGroupController::class, 'getUserTechnicalGroup']);
Route::post('user-technicals/work-orders', [UserTechnicalController::class, 'getWorkOrders']);
Route::get('reference-documents/{assetId}', function($assetId) {
    $data['documents'] = Document::where('asset_id', $assetId)->get();
    return view('modal.reference-documents', $data);
});
Route::post('reference-document/{id}', function($id) {
    $data['document'] = Document::where('id', $id)->first();
    return response()->json(['status' => '200', 'data' => $data['document']]);
});
Route::get('asset-materials/{assetId}', function($assetId) {
    $data['assetMaterials'] = AssetMaterial::where('asset_id', $assetId)->with(['bom'])->get();
    return response()->json(['status' => '200', 'data' => $data['assetMaterials']]);
});
Route::get('materials/{id}', function($id) {
    $data['material'] = Material::where('id', $id)->first();
    return response()->json(['status' => '200', 'data' => $data['material']]);
});
Route::post('change-material', [MaterialController::class, 'changeMaterial']);
// Route::post('generate-work-order', [ScheduleMaintenanceController::class, 'generateWorkOrder'])->name('test-generate');
