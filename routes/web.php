<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiLiburController;
use App\Http\Controllers\ScheduleController;


Route::get('/', function () {
    return view('index');
});


Route::get('/fetcholidays', [ApiLiburController::class, 'fetchHolidays']);
Route::get('/fetch', [ApiLiburController::class, 'index']);

Route::get('/schedule', [ScheduleController::class, 'index']);

Route::get('/schedule-create', [ScheduleController::class, 'create']);

use App\Http\Controllers\EmailController;

Route::get('/kirim-email', [EmailController::class, 'kirimEmail']);


Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');


Route::post('/schedule/{id}/toggle-status', [ScheduleController::class, 'toggleStatus'])->name('schedule.toggleStatus');

Route::post('/schedule/{id}/toggle-status', [ScheduleController::class, 'toggleStatus'])->name('schedule.toggleStatus');

Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

Route::post('/kirim/email/{id}', [EmailController::class, 'kirimEmail']);

Route::get('/schedule/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');