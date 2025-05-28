<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('admin/login');
});

Route::get('events/map',  [EventController::class, 'events_on_map'])->name('events_on_map');
