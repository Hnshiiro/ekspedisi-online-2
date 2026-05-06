<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\AdminCourierController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\CustomerPortalController;
use Illuminate\Support\Facades\Route;

/* ============================================================
 * PUBLIC ROUTES
 * ============================================================ */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lacak-paket', [HomeController::class, 'trackPage'])->name('tracking');
Route::match(['get','post'], '/cek-ongkir', [HomeController::class, 'cekOngkir'])->name('cek-ongkir');

/* ============================================================
 * STAFF AUTH & PROFILE
 * ============================================================ */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil', [StaffProfileController::class, 'index'])->name('profile');
    Route::put('/profil', [StaffProfileController::class, 'update'])->name('profile.update');
});

/* ============================================================
 * CUSTOMER AUTH
 * ============================================================ */
Route::prefix('pelanggan')->name('customer.')->group(function () {
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [AuthController::class, 'showCustomerLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'customerLogin'])->name('login.attempt');
        Route::get('/daftar', [AuthController::class, 'showCustomerRegisterForm'])->name('register');
        Route::post('/daftar', [AuthController::class, 'customerRegister'])->name('register.store');
    });
    Route::post('/logout', [AuthController::class, 'customerLogout'])->name('logout');

    Route::middleware('customer.auth')->group(function () {
        Route::get('/dashboard', [CustomerPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengiriman', [CustomerPortalController::class, 'shipments'])->name('shipments');
        Route::get('/pengiriman/baru', [CustomerPortalController::class, 'createShipment'])->name('shipments.create');
        Route::post('/pengiriman/baru', [CustomerPortalController::class, 'storeShipment'])->name('shipments.store');
        Route::get('/pengiriman/{shipment}/bayar', [CustomerPortalController::class, 'payShipment'])->name('shipments.pay');
        Route::get('/lacak', [CustomerPortalController::class, 'track'])->name('track');
        Route::get('/profil', [CustomerPortalController::class, 'profile'])->name('profile');
        Route::put('/profil', [CustomerPortalController::class, 'updateProfile'])->name('profile.update');
    });
});

/* ============================================================
 * ADMIN ROUTES
 * ============================================================ */
Route::prefix('admin')->name('admin.')->middleware(['auth:web','role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Master Data
    Route::resource('branches', BranchController::class);
    Route::post('/branches/{branch}/toggle', [BranchController::class, 'toggleStatus'])->name('branches.toggle');
    Route::resource('couriers', AdminCourierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('users', UserController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('routes', RouteController::class)->except(['show']);

    // Shipments
    Route::resource('shipments', ShipmentController::class);
    Route::post('/shipments/{shipment}/status', [ShipmentController::class, 'updateStatus'])->name('shipments.updateStatus');
    Route::post('/shipments/{shipment}/assign', [ShipmentController::class, 'assign'])->name('shipments.assign');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/mark-as-paid', [PaymentController::class, 'markAsPaid'])->name('payments.markAsPaid');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

/* ============================================================
 * BRANCH ADMIN ROUTES
 * ============================================================ */
Route::prefix('cabang')->name('branch.')->middleware(['auth:web','role:branch_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'branchDashboard'])->name('dashboard');
    Route::get('/pengiriman', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/pengiriman/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
    Route::post('/pengiriman/{shipment}/status', [ShipmentController::class, 'updateStatus'])->name('shipments.updateStatus');
    Route::post('/pengiriman/{shipment}/assign', [ShipmentController::class, 'assign'])->name('shipments.assign');
    Route::get('/kendaraan', [VehicleController::class, 'index'])->name('vehicles.index');
});

/* ============================================================
 * COURIER ROUTES
 * ============================================================ */
Route::prefix('kurir')->name('courier.')->middleware(['auth:web','role:courier'])->group(function () {
    Route::get('/dashboard', [CourierController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengiriman', [CourierController::class, 'shipments'])->name('shipments');
    Route::post('/pengiriman/{shipment}/status', [CourierController::class, 'updateStatus'])->name('updateStatus');
});

/* ============================================================
 * MANAGER ROUTES
 * ============================================================ */
Route::prefix('manajer')->name('manager.')->middleware(['auth:web','role:manager'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'managerDashboard'])->name('dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports');
    Route::get('/pengiriman', [ShipmentController::class, 'index'])->name('shipments');
    Route::get('/pengiriman/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
});
