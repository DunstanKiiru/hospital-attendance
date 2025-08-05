<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\HR\HrDashboard;
use App\Livewire\Supervisor\SupervisorDashboard;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use App\Livewire\UserManager;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Employee dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'employee'])
    ->name('employee.dashboard');

// Shared settings routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
});

// HR-only routes
Route::middleware(['auth', 'hr'])->group(function () {
    Route::get('/hr/dashboard', HrDashboard::class)->name('hr.dashboard');
});

// Supervisor-only routes
Route::middleware(['auth', 'supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', SupervisorDashboard::class)->name('supervisor.dashboard');
});

// Admin & HR can manage users
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/users', UserManager::class)->name('users.index');
});

require __DIR__ . '/auth.php';
