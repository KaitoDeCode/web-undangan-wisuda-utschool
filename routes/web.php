<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\KehadiranController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix("/admin")->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get("/login", AuthenticationController::class)->name('login.view');
        Route::post("/login", [AuthenticationController::class, 'login'])->name('login');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get("/dashboard", DashboardController::class)->name('dashboard');
        Route::get("/user/invitation/{user_id}", [DashboardController::class, "download_pdf"])->name('get-invitation');
        Route::delete("/user/delete/{user_id}", [KehadiranController::class, 'delete'])->name('delete-user');
    });
});
Route::controller(KehadiranController::class)->group(function () {
    Route::get('/', 'index')->name('kehadiran.index');
    Route::post('/store', 'store')->name('kehadiran.store');
});
