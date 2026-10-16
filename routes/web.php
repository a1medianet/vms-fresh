<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PreArrivalController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\HousingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportExportController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/pre-arrival/{token}', [PreArrivalController::class, 'show'])->name('pre-arrival.show');
Route::post('/pre-arrival/{token}', [PreArrivalController::class, 'submit'])->name('pre-arrival.submit');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::middleware('permission:manage_users')->group(function () {
        Route::get('/dashboard/users', [UserController::class, 'index'])->name('dashboard.users.index');
        Route::post('/dashboard/users', [UserController::class, 'store'])->name('dashboard.users.store');
        Route::put('/dashboard/users/{user}', [UserController::class, 'update'])->name('dashboard.users.update');
        Route::delete('/dashboard/users/{user}', [UserController::class, 'destroy'])->name('dashboard.users.destroy');
    });

    // Roles Management
    Route::middleware('permission:manage_users')->group(function () {
        Route::get('/dashboard/roles', [RoleController::class, 'index'])->name('dashboard.roles.index');
        Route::post('/dashboard/roles', [RoleController::class, 'store'])->name('dashboard.roles.store');
        Route::put('/dashboard/roles/{role}', [RoleController::class, 'update'])->name('dashboard.roles.update');
        Route::delete('/dashboard/roles/{role}', [RoleController::class, 'destroy'])->name('dashboard.roles.destroy');
    });

    // Permissions Management
    Route::middleware('permission:manage_users')->group(function () {
        Route::get('/dashboard/permissions', [PermissionController::class, 'index'])->name('dashboard.permissions.index');
        Route::post('/dashboard/permissions', [PermissionController::class, 'store'])->name('dashboard.permissions.store');
        Route::put('/dashboard/permissions/{permission}', [PermissionController::class, 'update'])->name('dashboard.permissions.update');
        Route::delete('/dashboard/permissions/{permission}', [PermissionController::class, 'destroy'])->name('dashboard.permissions.destroy');
    });

    // Pre-Arrival Management
    Route::middleware('permission:manage_prearrival')->group(function () {
        Route::get('/dashboard/pre-arrival', [PreArrivalController::class, 'index'])->name('dashboard.pre-arrival.index');
        Route::get('/dashboard/pre-arrival/create', [PreArrivalController::class, 'create'])->name('dashboard.pre-arrival.create');
        Route::post('/dashboard/pre-arrival', [PreArrivalController::class, 'store'])->name('dashboard.pre-arrival.store');
        Route::delete('/dashboard/pre-arrival/{preArrival}', [PreArrivalController::class, 'destroy'])->name('dashboard.pre-arrival.destroy');
    });

    // Visitors Management
    Route::middleware('permission:manage_visitors')->group(function () {
        Route::get('/dashboard/visitors', [VisitorController::class, 'index'])->name('dashboard.visitors.index');
        Route::get('/dashboard/visitors/create', [VisitorController::class, 'create'])->name('dashboard.visitors.create');
        Route::post('/dashboard/visitors', [VisitorController::class, 'store'])->name('dashboard.visitors.store');
        Route::get('/dashboard/visitors/{visitor}', [VisitorController::class, 'show'])->name('dashboard.visitors.show');
        Route::put('/dashboard/visitors/{visitor}', [VisitorController::class, 'update'])->name('dashboard.visitors.update');
        Route::post('/dashboard/visitors/{visitor}/check-in', [VisitorController::class, 'checkIn'])->name('dashboard.visitors.check-in');
        Route::post('/dashboard/visitors/{visitor}/check-out', [VisitorController::class, 'checkOut'])->name('dashboard.visitors.check-out');
        Route::delete('/dashboard/visitors/{visitor}', [VisitorController::class, 'destroy'])->name('dashboard.visitors.destroy');
    });

    // Housing Management
    Route::middleware('permission:manage_housing')->group(function () {
        Route::get('/dashboard/housing/buildings', [HousingController::class, 'buildings'])->name('dashboard.housing.buildings');
        Route::post('/dashboard/housing/buildings', [HousingController::class, 'storeBuilding'])->name('dashboard.housing.buildings.store');
        Route::put('/dashboard/housing/buildings/{building}', [HousingController::class, 'updateBuilding'])->name('dashboard.housing.buildings.update');
        Route::delete('/dashboard/housing/buildings/{building}', [HousingController::class, 'destroyBuilding'])->name('dashboard.housing.buildings.destroy');

        Route::post('/dashboard/housing/floors', [HousingController::class, 'storeFloor'])->name('dashboard.housing.floors.store');
        Route::put('/dashboard/housing/floors/{floor}', [HousingController::class, 'updateFloor'])->name('dashboard.housing.floors.update');
        Route::delete('/dashboard/housing/floors/{floor}', [HousingController::class, 'destroyFloor'])->name('dashboard.housing.floors.destroy');

        Route::get('/dashboard/housing/rooms', [HousingController::class, 'rooms'])->name('dashboard.housing.rooms');
        Route::post('/dashboard/housing/rooms', [HousingController::class, 'storeRoom'])->name('dashboard.housing.rooms.store');
        Route::put('/dashboard/housing/rooms/{room}', [HousingController::class, 'updateRoom'])->name('dashboard.housing.rooms.update');
        Route::delete('/dashboard/housing/rooms/{room}', [HousingController::class, 'destroyRoom'])->name('dashboard.housing.rooms.destroy');

        Route::get('/dashboard/housing/assignments', [HousingController::class, 'assignments'])->name('dashboard.housing.assignments');
        Route::get('/dashboard/housing/assignments/create', [HousingController::class, 'createAssignment'])->name('dashboard.housing.assignments.create');
        Route::post('/dashboard/housing/assignments', [HousingController::class, 'storeAssignment'])->name('dashboard.housing.assignments.store');
        Route::post('/dashboard/housing/assignments/{assignment}/check-out', [HousingController::class, 'checkOutAssignment'])->name('dashboard.housing.assignments.check-out');
    });

    // Reports
    Route::middleware('permission:view_reports')->group(function () {
        Route::get('/dashboard/reports', [ReportController::class, 'index'])->name('dashboard.reports.index');
        Route::get('/dashboard/reports/daily', [ReportController::class, 'daily'])->name('dashboard.reports.daily');
        Route::get('/dashboard/reports/weekly', [ReportController::class, 'weekly'])->name('dashboard.reports.weekly');
        Route::get('/dashboard/reports/monthly', [ReportController::class, 'monthly'])->name('dashboard.reports.monthly');
        Route::get('/dashboard/reports/yearly', [ReportController::class, 'yearly'])->name('dashboard.reports.yearly');
    });

    // Import/Export
    Route::middleware('permission:import_export')->group(function () {
        Route::get('/dashboard/import-export', [ImportExportController::class, 'index'])->name('dashboard.import-export.index');
        Route::post('/dashboard/import-export/import', [ImportExportController::class, 'import'])->name('dashboard.import-export.import');
        Route::get('/dashboard/import-export/export', [ImportExportController::class, 'export'])->name('dashboard.import-export.export');
    });
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});
