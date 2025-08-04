<?php

use App\Livewire\HR\HrDashboard;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Supervisor\SupervisorDashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('employee.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['admin','auth'])->group(function(){
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
});

Route::middleware(['HR','auth'])->group(function(){
    Route::get('/hr/dashboard', HrDashboard::class)->name('hr.dashboard');
});

Route::middleware(['supervisor','auth'])->group(function(){
    Route::get('/supervisor/dashboard', SupervisorDashboard::class)->name('supervisor.dashboard');
});

require __DIR__.'/auth.php';
