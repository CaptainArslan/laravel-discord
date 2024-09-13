<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscordController;

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('user/activity', [DashboardController::class, 'activity'])->name('user.activity');
    Route::delete('/activity/{id}', [DashboardController::class, 'destroyActivity'])->name('activity.destroy');


    Route::get('auth/discord', [DiscordController::class, 'redirectToDiscord']);
    Route::get('auth/discord/callback', [DiscordController::class, 'handleDiscordCallback']);
    Route::get('discord/profile',  [DiscordController::class, 'profile']);
});

require __DIR__ . '/auth.php';
