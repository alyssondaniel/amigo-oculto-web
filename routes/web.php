<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Models\Group;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('profile', ProfileController::class)
        ->only(['edit', 'update', 'destroy']);
    Route::resource('gifts', GiftController::class);

    Route::get('/groups/{id}/restore', [GroupController::class, 'restore'])
        ->name('groups.restore');
    Route::put('/groups/{group}/invite', [GroupController::class, 'invite'])
        ->name('groups.invite');
    Route::put('/groups/{group}/accept-invite', [GroupController::class, 'acceptInvite'])
        ->name('groups.acceptInvite');
    Route::post('/groups/{group}/run-draw-lots', [GroupController::class, 'runDrawLots'])
        ->name('groups.runDrawLots');
    Route::resource('groups', GroupController::class);
});

require __DIR__ . '/auth.php';
