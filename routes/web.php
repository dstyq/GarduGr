<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BomController;
use App\Http\Controllers\CctvController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationCategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleMaintenanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserTechnicalController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data['page_title'] = 'Login';
    return view('auth.login', $data);
})->name('user.login');

// Modal
// - Material
// Route::get('modal-change-material/{id}', [MaterialController::class, 'changeModal'])->name('materials.change-modal');

Route::middleware('auth:web')->group(function () {
    // Dashboard
    Route::get('overview', [DashboardController::class, 'overview'])->name('dashboard.overview');
    Route::get('maps', [DashboardController::class, 'maps'])->name('dashboard.maps');

    // Asset
    // Route::resource('assets', AssetController::class);

    // // Schedule Maintenance
    // Route::resource('schedule-maintenances', ScheduleMaintenanceController::class);

    // // Work Order
    // Route::resource('work-orders', WorkOrderController::class);

    // // Cctv
    Route::resource('cctv', CctvController::class);

    // // Location Categories
    // Route::resource('location-categories', LocationCategoryController::class)->except([
    //     'show'
    // ]);

     // Master Data
     Route::get('master-data', function () {
        $data['page_title'] = 'Master Data';
        return view('master-data.index', $data);
    })->name('master-data.index');

    // Departement
    Route::resource('departements', DepartementController::class);

    // Users
    Route::patch('change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::resource('users', UserController::class)->except([
        'show'
    ]);;

    // // Categories
    // Route::resource('categories', CategoryController::class)->except([
    //     'show'
    // ]);

    // // Types
    // Route::resource('types', TypeController::class)->except([
    //     'show'
    // ]);

    // // Material
    // Route::resource('materials', MaterialController::class)->except([
    //     'show'
    // ]);

    // // BOM
    // Route::resource('boms', BomController::class);
    // Route::get('boms/{assetId}/{bomId}', [BomController::class, 'showMaterial']);

    // // Task
    // Route::get('tasks/create-modal', [TaskController::class, 'createModal'])->name('tasks.create-modal');
    // Route::resource('tasks', TaskController::class)->except([
    //     'show'
    // ]);


    // // Task Group
    // Route::get('task-groups/create-modal', [TaskGroupController::class, 'createModal'])->name('task-groups.create-modal');
    // Route::resource('task-groups', TaskGroupController::class);

    // // Report
    // Route::get('reports', [ReportController::class, 'index'])->name('reports');
    // Route::get('asset-reports/{id}', [ReportController::class, 'viewAssetReport'])->name('asset-reports');
    // Route::get('work-order-reports/{id}', [ReportController::class, 'viewWorkOrderReport'])->name('work-order-reports');
    // Route::get('maintenance-reports/{id}', [ReportController::class, 'viewMaintenanceReport'])->name('maintenance-reports');

    // // User Technical
    // Route::get('user-technicals/create-modal', [UserTechnicalController::class, 'createModal'])->name('user-technicals.create-modal');
    // Route::patch('user-technicals-change-password', [UserTechnicalController::class, 'changePassword'])->name('user-technicals.change-password');
    // Route::resource('user-technicals', UserTechnicalController::class)->except([
    //     'show'
    // ]);

    // // User Technical Group
    // Route::get('user-technical-groups/create-modal', [UserGroupController::class, 'createModal'])->name('user-technical-groups.create-modal');
    // Route::resource('user-technical-groups', UserGroupController::class);
});

// Route::prefix('user-technical')->group(function () {
//     Route::get('/login', [LoginController::class, 'formLogin'])->name('user-technical.form-login');
//     Route::post('/login', [LoginController::class, 'login'])->name('user-technical.login');
//     Route::get('/logout', [LoginController::class, 'logout'])->name('user-technical.logout');

//     Route::get('/show-user-group/{id}',[UserTechnicalController::class, 'showUserGroup'])->middleware('auth:user-technical')->name('user-technical.show-user-group');
//     Route::get('/dashboard',[UserTechnicalController::class, 'dashboard'])->middleware('auth:user-technical')->name('user-technical.dashboard');
//     Route::get('/work-orders',[UserTechnicalController::class, 'workOrder'])->middleware('auth:user-technical')->name('user-technical.work-order');
//     Route::get('/work-orders/{id}/edit',[UserTechnicalController::class, 'editWorkOrder'])->middleware('auth:user-technical')->name('user-technical.work-order-edit');
//     Route::patch('/work-orders/{id}',[UserTechnicalController::class, 'updateWorkOrder'])->middleware('auth:user-technical')->name('user-technical.work-order-update');
// });
