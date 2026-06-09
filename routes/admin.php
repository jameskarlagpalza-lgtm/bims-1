<?php

use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('users/{user}/assign-campus', [UserController::class, 'assignCampus'])->name('users.assignCampus');
    Route::post('users/bulk-assign-campus', [UserController::class, 'bulkAssignCampus'])->name('users.bulkAssignCampus');
    Route::post('users/save-all-assignments', [UserController::class, 'saveAllAssignments'])->name('users.saveAllAssignments');
    Route::resource('users', UserController::class);
    Route::resource('buildings', BuildingController::class)->only(['index', 'show']);
    Route::resource('buildings.rooms', RoomController::class)->only(['index', 'show']);
    Route::resource('buildings.items', ItemController::class)->only(['index', 'show']);

});


