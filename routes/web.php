<?php

use App\Http\Controllers\Auth\AppLogController;
use App\Http\Controllers\Auth\AuthLogController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

    Route::resource('/auth-logs', AuthLogController::class)->only(['index', 'show']);
    Route::resource('/app-logs', AppLogController::class)->only(['index', 'show']);

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/permissions', PermissionController::class);
    Route::patch('/permissions', [PermissionController::class, 'bulkUpdate'])->name('permissions.bulkUpdate');
    Route::delete('/permissions', [PermissionController::class, 'bulkDestroy'])->name('permissions.bulkDestroy');

    Route::resource('/roles', RoleController::class);
    Route::patch('/roles', [RoleController::class, 'bulkUpdate'])->name('roles.bulkUpdate');
    Route::delete('/roles', [RoleController::class, 'bulkDestroy'])->name('roles.bulkDestroy');

    Route::resource('/menus', MenuController::class);
    Route::patch('/menus', [MenuController::class, 'bulkUpdate'])->name('menus.bulkUpdate');
    Route::delete('/menus', [MenuController::class, 'bulkDestroy'])->name('menus.bulkDestroy');

    Route::resource('/users', UserController::class);
    Route::patch('/users', [UserController::class, 'bulkUpdate'])->name('users.bulkUpdate');
    Route::delete('/users', [UserController::class, 'bulkDestroy'])->name('users.bulkDestroy');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,5');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});
