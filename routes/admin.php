<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\BusinessPackageController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Auth\RegisteredUserController;
Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::get('admin-login', [LoginController::class, 'showLoginForm'])->name('admin_login');
    Route::post('admin-login', [LoginController::class, 'adminLogin'])->name('admin_login.submit');
    Route::middleware('auth:admin')->group(function () {
    // Route::group([],function () {
        // Dashboard
        Route::get('admin-dashboard', [DashboardController::class, 'index'])->name('admin_dashboard');
        //On barding New business
        Route::get('configuration', [RegisteredUserController::class, 'create'])->name('register');
        // Business Registration (New Methods)
        Route::get('businesses/register-user', [BusinessController::class, 'showRegisterForm'])->name('businesses.register.form');
        Route::post('businesses/register-user', [BusinessController::class, 'registerBusinessUser'])->name('businesses.register.submit');
        
        // Business General Form (Add/Edit)
        Route::get('businesses/general', [BusinessController::class, 'general'])->name('businesses.general');
        Route::post('businesses/general', [BusinessController::class, 'storeGeneral'])->name('businesses.general.store');
        
        Route::post('configuration', [RegisteredUserController::class, 'store'])->middleware('throttle:5,1');
        // Logout
        Route::post('admin-logout', LogoutController::class)->name('admin_logout');
        // Business Management
        Route::get('businesses', [BusinessController::class, 'index'])->name('businesses.index');
        Route::get('businesses/{id}', [BusinessController::class, 'show'])->name('businesses.show');
        Route::get('businesses/createuser/{id}', [BusinessController::class, 'createUser'])->name('businesses.create-user');
        Route::post('businesses/registeruser', [BusinessController::class, 'registerUser'])->name('businesses.register');
        // Log Management
        Route::get('logs', [LogController::class, 'show'])->name('logs.show');
        Route::get('logs/clear', [LogController::class, 'clear'])->name('logs.clear');
        // Database Utilities
        Route::get('db/clone', [DatabaseController::class, 'showCloneForm'])->name('db.clone.form');
        Route::post('db/clone', [DatabaseController::class, 'clone'])->name('db.clone');
        //Packages
        // Package Routes
        Route::prefix('packages')->name('packages.')->group(function () {
            Route::get('/', [PackageController::class, 'index'])->name('index');
            Route::get('/create', [PackageController::class, 'create'])->name('create');
            Route::post('/', [PackageController::class, 'store'])->name('store');
            Route::get('/{package}/edit', [PackageController::class, 'edit'])->name('edit');
            Route::put('/{package}', [PackageController::class, 'update'])->name('update');
            Route::delete('/{package}', [PackageController::class, 'destroy'])->name('destroy');
        });
        //Package Assignment
        Route::get('business-packages/assign', [BusinessPackageController::class, 'showAssignForm'])
            ->name('business_packages.assign.form');
        Route::post('business-packages/assign', [BusinessPackageController::class, 'assignPackage'])
            ->name('business_packages.assign');
        Route::get('business-packages', [BusinessPackageController::class, 'index'])
            ->name('business_packages.index');
        Route::post('business-packages/renew', [BusinessPackageController::class, 'renew'])
            ->name('business_packages.renew');
        Route::post('business_packages/toggle', [BusinessPackageController::class, 'toggleActive'])
            ->name('business_packages.toggle');

        // Log Management
        Route::get('logs', [LogController::class, 'index'])->name('logs.index');

        // Support Tickets
        Route::prefix('support-tickets')->name('support_tickets.')->group(function () {
            Route::get('/', [SupportTicketController::class, 'index'])->name('index');
            Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
            Route::post('/', [SupportTicketController::class, 'store'])->name('store');
            Route::get('/{supportTicket}', [SupportTicketController::class, 'show'])->name('show');
            Route::post('/{id}/status', [SupportTicketController::class, 'updateStatus'])->name('update_status');
            Route::post('/{id}/comment', [SupportTicketController::class, 'addComment'])->name('add_comment');
        });

        // Global Settings
        Route::get('settings/mail', [AdminSettingController::class, 'mailSetting'])->name('settings.mail');
        Route::post('settings/mail', [AdminSettingController::class, 'mailSettingStore'])->name('settings.mail.store');
    });
});
