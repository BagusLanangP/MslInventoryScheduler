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
    //dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User
    Route::get('/create-user', [AdminController::class, 'createUser'])->name('admin.create-user');
    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('admin.store-user');
    Route::get('/add-gmail', [AdminController::class, 'addGmail'])->name('admin.add-gmail');
   
    
    // Inventory
    Route::get('/inventory', [InventoryCheckingController::class, 'index'])->name('inventory_index');
    Route::get('/inventory-checkings/create', [InventoryCheckingController::class, 'create'])->name('inventory_checkings.create');
    Route::get('/inventory/edit/{id}', [InventoryCheckingController::class, 'edit'])->name('inventory.edit');
    Route::post('/store-inventory', [InventoryCheckingController::class, 'store'])->name('admin.store-inventory');
    Route::delete('/inventory/delete/{id}', [InventoryCheckingController::class, 'destroy'])->name('inventory.destroy');

    // Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier_index');
    Route::get('/create-supplier', [SupplierController::class, 'create'])->name('admin.create-supplier');
    Route::post('/store-supplier', [SupplierController::class, 'store'])->name('admin.store-supplier');
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::get('/supplier/show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::patch('/supplier/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('supplier.toggleStatus');
    Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
   

    // <a href="{{ route('admin.create-inventory') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Create Supplier</a>
    // <a href="{{ route('admin.create-jenis-barang') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Create Jenis Barang</a>
    // <a href="{{ route('admin.create-inventory') }}" class="block py-2 px-4 hover:bg-blue-700 rounded">Create Inventory</a>
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
