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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('discord/connect', [DiscordController::class, 'connect'])->name('discord.connect');
    Route::get('auth/discord', [DiscordController::class, 'redirectToDiscord'])->name('auth.discord');
    Route::get('auth/callback/discord', [DiscordController::class, 'handleProviderCallback'])->name('auth.discord.callback');

    Route::middleware(['role:admin|moderator|basic'])->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware(['role:admin|moderator'])->group(function () {
        Route::get('user/activity', [DashboardController::class, 'activity'])->name('user.activity');
    });

    Route::middleware(['role:admin', 'log-unauthorized-access:admin'])->group(function () {
        Route::delete('/activity/{id}', [DashboardController::class, 'destroyActivity'])->name('activity.destroy');
    });
});

require __DIR__ . '/auth.php';
