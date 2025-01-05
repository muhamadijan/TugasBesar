<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\AuditLogController;
/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/owner-dashboard', function () {
        return view('owner.dashboard');
    })->middleware('role:owner')->name('owner.dashboard');

    Route::get('/manager-dashboard', function () {
        return view('manager.dashboard');
    })->middleware('role:manager')->name('manager.dashboard');

    Route::get('/supervisor-dashboard', function () {
        return view('supervisor.dashboard');
    })->middleware('role:supervisor')->name('supervisor.dashboard');

    Route::get('/cashier-dashboard', function () {
        return view('cashier.dashboard');
    })->middleware('role:cashier')->name('cashier.dashboard');

    Route::get('/warehouse-dashboard', function () {
        return view('warehouse.dashboard');
    })->middleware('role:warehouse_staff')->name('warehouse.dashboard');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['auth', 'role:owner'])->group(function () {
        Route::resource('users', RegisterController::class)->except(['show']);
    });


    Route::middleware(['auth', 'role:owner,manager,supervisor'])->group(function () {
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit_logs.index');
    });


    Route::get('/', function () {
        return view('pages.home');
    });

    Route::middleware('auth')->group(function () {
        Route::resource('stores', StoreController::class)->except(['show']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::resource('transactions', TransactionController::class);
    });


    Route::resource('products', ProductController::class);

    Route::resource('transaction_details', TransactionDetailController::class);


    // Route untuk halaman profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk perubahan password
    Route::get('/password/edit', [PasswordController::class, 'edit'])->name('password.edit');
    Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');
});

require __DIR__.'/auth.php';
