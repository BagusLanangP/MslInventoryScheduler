<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiLiburController;
use App\Http\Controllers\ScheduleController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/fetcholidays', [ApiLiburController::class, 'fetchHolidays']);
Route::get('/fetch', [ApiLiburController::class, 'index']);

Route::get('/schedule-create', [ScheduleController::class, 'create']);