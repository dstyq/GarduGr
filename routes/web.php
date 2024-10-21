<?php

use App\Http\Controllers\AccessDoorController;
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
use App\Http\Controllers\HistoryLogController;
use App\Http\Controllers\HistoryNotificationController;
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
use App\Http\Controllers\GarduController;
use App\Http\Controllers\ImpedansiTrafoController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('auth.login', ['page_title' => 'Login']);
})->name('user.login');

// Authenticated Routes
Route::middleware('auth:web')->group(function () {

    // Dashboard Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('overview', [DashboardController::class, 'overview'])->name('overview');
        Route::get('maps-cctv', [DashboardController::class, 'mapsCctv'])->name('maps-cctv');
        Route::get('maps-access-door', [DashboardController::class, 'mapsAccessDoor'])->name('maps-access-door');
    });

    // Asset Management Routes
    Route::resource('assets', AssetController::class);
    Route::resource('schedule-maintenances', ScheduleMaintenanceController::class);
    Route::resource('work-orders', WorkOrderController::class);

    // CCTV Management
    Route::resource('cctv', CctvController::class);

    // Access Door Management
    Route::resource('access-door', AccessDoorController::class);

    // Location Management
    Route::resource('locations', LocationController::class);
    Route::resource('location-categories', LocationCategoryController::class)->except(['show']);

    // Master Data
    Route::get('master-data', function () {
        return view('master-data.index', ['page_title' => 'Master Data']);
    })->name('master-data.index');

    // Department Management
    Route::resource('departements', DepartementController::class);

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::patch('change-password', [UserController::class, 'changePassword'])->name('change-password');
        Route::resource('/', UserController::class)->except(['show']);
    });

    // History Logs
    Route::resource('history-log', HistoryLogController::class)->except(['show', 'create', 'store', 'edit', 'update']);
    Route::resource('notification-log', HistoryNotificationController::class)->except(['show', 'create', 'store', 'edit', 'update']);

    // Categories and Types
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('types', TypeController::class)->except(['show']);

    // Material Management
    Route::resource('materials', MaterialController::class)->except(['show']);

    // BOM Management
    Route::resource('boms', BomController::class);
    Route::get('boms/{assetId}/{bomId}', [BomController::class, 'showMaterial']);

    // Task Management
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('create-modal', [TaskController::class, 'createModal'])->name('create-modal');
        Route::resource('/', TaskController::class)->except(['show']);
    });

    // Task Group Management
    Route::prefix('task-groups')->name('task-groups.')->group(function () {
        Route::get('create-modal', [TaskGroupController::class, 'createModal'])->name('create-modal');
        Route::resource('/', TaskGroupController::class);
    });

    // Reporting
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('');
        Route::get('asset/{id}', [ReportController::class, 'viewAssetReport'])->name('asset');
        Route::get('work-order/{id}', [ReportController::class, 'viewWorkOrderReport'])->name('work-order');
        Route::get('maintenance/{id}', [ReportController::class, 'viewMaintenanceReport'])->name('maintenance');
    });

    // User Technical Management
    Route::prefix('user-technicals')->name('user-technicals.')->group(function () {
        Route::get('create-modal', [UserTechnicalController::class, 'createModal'])->name('create-modal');
        Route::patch('change-password', [UserTechnicalController::class, 'changePassword'])->name('change-password');
        Route::resource('/', UserTechnicalController::class)->except(['show']);
    });

    // User Technical Group Management
    Route::prefix('user-technical-groups')->name('user-technical-groups.')->group(function () {
        Route::get('create-modal', [UserGroupController::class, 'createModal'])->name('create-modal');
        Route::resource('/', UserGroupController::class);
    });

    // Gardu and Impedansi Trafo Management
    Route::resource('gardu', GarduController::class);
    Route::resource('impedansi-trafo', ImpedansiTrafoController::class);
});
