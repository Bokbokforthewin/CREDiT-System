<?php

use App\Livewire\Admin\FullChargeView as FullChargeView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\BusinessOfficeRegister;
use App\Livewire\RedirectUser;
use App\Livewire\Business\Dashboard as BusinessDashboard;
use App\Livewire\Business\ReportsDashboard as ReportsDashboard;
use App\Livewire\Admin\Dashboard as CentralAdminDashboard;
use App\Livewire\Business\ManageFamiliesPage as ManageFamiliesPage;
use App\Livewire\Business\DepartmentManagement as DepartmentManagement;
use App\Livewire\Business\LimitsAndRestrictions as LimitsAndRestrictions;
use App\Livewire\Business\AuditSection as AuditSection;
use App\Livewire\Frontdesk\ChargeManagement as ChargeManagement;
use App\Livewire\Frontdesk\UniversalDashboard;

// Frontdesk Dashboards
use App\Livewire\Store\Dashboard as StoreDashboard;
use App\Livewire\Fastfood\Dashboard as FastfoodDashboard;
use App\Livewire\Cafeteria\Dashboard as CafeteriaDashboard;
use App\Livewire\Laundry\Dashboard as LaundryDashboard;
use App\Livewire\Water\Dashboard as WaterDashboard;
use App\Livewire\Garden\Dashboard as GardenDashboard;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Business Office Registration Page
Route::get('/register/business-office', BusinessOfficeRegister::class)
    ->middleware('guest')
    ->name('business.register');

// ✅ Login Redirect Handler
Route::get('/livewire-login-handler', RedirectUser::class)
    ->middleware(['auth', 'verified']);

// ✅ Protected Routes for All Authenticated Users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Generic Jetstream Dashboard
    Route::get('/dashboard', RedirectUser::class
    )->name('dashboard');

    // ✅ Centralized Admin Dashboard
    Route::get('/admin/dashboard', CentralAdminDashboard::class)
        ->name('admin.dashboard');

    Route::get('/admin/full-charge-view', FullChargeView::class)
    ->name('admin.fullchargeview');

    // ✅ Business Office Dashboard
    Route::get('/business/dashboard', BusinessDashboard::class)
        ->name('business.dashboard');

    Route::get('/business/reports', ReportsDashboard::class)
    ->name('business.reportsdashboard');

    Route::get('/business/manage-families-page', ManageFamiliesPage::class)
    ->name('business.managefamiliespage');

    Route::get('/business/department-management', DepartmentManagement::class)
    ->name('business.departmentmanagement');

    Route::get('/business/limits-and-restrictions', LimitsAndRestrictions::class)
    ->name('business.limitsandrestrictions');

    Route::get('/business/audit-section', AuditSection::class)
    ->name('business.auditsection');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/frontdesk/{department}', UniversalDashboard::class)
            ->middleware('can:access,department')
            ->name('frontdesk.dashboard');
    
        // Route
        Route::get('/frontdesk/{department}/charge-management', ChargeManagement::class)
        ->middleware('can:access,department')
        ->name('frontdesk.chargemanagement');
    });

    // ✅ Frontdesk Dashboards (By Department)
    // Route::get('/store/dashboard', StoreDashboard::class)->name('store.dashboard');
    // Route::get('/fastfood/dashboard', FastfoodDashboard::class)->name('fastfood.dashboard');
    // Route::get('/cafeteria/dashboard', CafeteriaDashboard::class)->name('cafeteria.dashboard');
    // Route::get('/laundry/dashboard', LaundryDashboard::class)->name('laundry.dashboard');
    // Route::get('/water/dashboard', WaterDashboard::class)->name('water.dashboard');
    // Route::get('/garden/dashboard', GardenDashboard::class)->name('garden.dashboard');
});
