<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiLiburController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryCheckingController;





Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/create-user', [AdminController::class, 'createUser'])->name('admin.create-user');
    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('admin.store-user');
    Route::get('/add-gmail', [AdminController::class, 'addGmail'])->name('admin.add-gmail');
    Route::get('/create-supplier', [SupplierController::class, 'create'])->name('admin.create-supplier');
    Route::post('/store-supplier', [SupplierController::class, 'store'])->name('admin.store-supplier');
    Route::get('/inventory-checkings/create', [InventoryCheckingController::class, 'create'])->name('inventory_checkings.create');
    Route::post('/store-inventory', [InventoryCheckingController::class, 'store'])->name('admin.store-inventory');
});

Route::get('/', function () {
    return view('index');
});




Route::get('/fetcholidays', [ApiLiburController::class, 'fetchHolidays']);
Route::get('/fetch', [ApiLiburController::class, 'index']);

Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

Route::get('/schedule-create', [ScheduleController::class, 'create'])->name('schedule.create');


// Route::get('/admin/dashboard', function () {
//     return view('admin.createUser');
// });



Route::get('/kirim-email', [EmailController::class, 'kirimEmail']);


Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');


Route::post('/schedule/{id}/toggle-status', [ScheduleController::class, 'toggleStatus'])->name('schedule.toggleStatus');

Route::post('/schedule/{id}/toggle-status', [ScheduleController::class, 'toggleStatus'])->name('schedule.toggleStatus');

Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

Route::post('/kirim/email/{id}', [EmailController::class, 'kirimEmail']);

Route::get('/schedule/{id}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
Route::put('/schedule/{id}', [ScheduleController::class, 'update'])->name('schedule.update');




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
