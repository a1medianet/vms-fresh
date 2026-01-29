<?php

use Illuminate\Support\Facades\Route;
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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All routes for the Visitor Management System.
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public pre-arrival form (one-time token)
Route::get('/pre-arrival/{token}', [PreArrivalController::class, 'showPublicForm'])->name('prearrival.public.show');
Route::post('/pre-arrival/{token}', [PreArrivalController::class, 'submitPublicForm'])->name('prearrival.public.submit');

// Locale switcher
Route::get('/locale/{locale}', [AuthController::class, 'switchLocale'])->name('locale.switch');

Route::middleware(['auth', 'setlocale'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::middleware(['role:Super Admin,Admin'])->group(function () {
        // Users & Roles management
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->only(['index']);
    });

    // Pre-Arrival
    Route::middleware(['permission:manage_prearrival'])->group(function () {
        Route::resource('pre-arrival', PreArrivalController::class)->except(['show']);
    });

    // Visitors
    Route::middleware(['permission:manage_visitors'])->group(function () {
        Route::resource('visitors', VisitorController::class);
        Route::post('visitors/{visitor}/check-in', [VisitorController::class, 'checkIn'])->name('visitors.checkin');
        Route::post('visitors/{visitor}/check-out', [VisitorController::class, 'checkOut'])->name('visitors.checkout');
    });

    // Housing
    Route::middleware(['permission:manage_housing'])->group(function () {
        Route::get('housing', [HousingController::class, 'index'])->name('housing.index');
        Route::get('housing/create', [HousingController::class, 'create'])->name('housing.create');
        Route::post('housing', [HousingController::class, 'store'])->name('housing.store');
        Route::get('housing/{assignment}/edit', [HousingController::class, 'edit'])->name('housing.edit');
        Route::put('housing/{assignment}', [HousingController::class, 'update'])->name('housing.update');
        Route::delete('housing/{assignment}', [HousingController::class, 'destroy'])->name('housing.destroy');
    });

    // Reports
    Route::middleware(['permission:view_reports'])->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    });

    // Import / Export
    Route::middleware(['permission:import_export'])->group(function () {
        Route::get('import-export', [ImportExportController::class, 'index'])->name('import_export.index');
        Route::post('import-export/visitors', [ImportExportController::class, 'importVisitors'])->name('import_export.visitors.import');
        Route::post('import-export/housing', [ImportExportController::class, 'importHousing'])->name('import_export.housing.import');
        Route::get('import-export/visitors', [ImportExportController::class, 'exportVisitors'])->name('import_export.visitors.export');
        Route::get('import-export/pre-arrivals', [ImportExportController::class, 'exportPreArrivals'])->name('import_export.pre_arrivals.export');
    });
}
);

