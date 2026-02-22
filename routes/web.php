<?php

use App\Livewire\Admin\Alumni\AlumniIndex;
use App\Livewire\Admin\Alumni\AlumniCreate;
use App\Livewire\Admin\Alumni\AlumniEdit;
use App\Livewire\Admin\TracerPeriod\TracerPeriodIndex;
use App\Livewire\Admin\TracerPeriod\TracerPeriodCreate;
use App\Livewire\Admin\TracerPeriod\TracerPeriodEdit;
use App\Livewire\Admin\TracerQuestion\TracerQuestionIndex;
use App\Livewire\Admin\TracerQuestion\TracerQuestionCreate;
use App\Livewire\Admin\TracerQuestion\TracerQuestionEdit;
use App\Livewire\Admin\TracerOption\TracerOptionIndex;
use App\Livewire\Admin\TracerOption\TracerOptionCreate;
use App\Livewire\Admin\TracerOption\TracerOptionEdit;
use App\Livewire\Alumni\TracerStudyForm;
use App\Livewire\Alumni\TracerPeriodList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin & Prodi Management Routes
Route::middleware(['auth', 'verified', 'role:admin,prodi'])->prefix('admin')->group(function () {
    // Alumni Management
    Route::get('/alumni', AlumniIndex::class)->name('admin.alumni.index');
    Route::get('/alumni/create', AlumniCreate::class)->name('admin.alumni.create');
    Route::get('/alumni/{id}/edit', AlumniEdit::class)->name('admin.alumni.edit');

    // Tracer Period Management
    Route::get('/tracer-periods', TracerPeriodIndex::class)->name('admin.tracer-periods.index');
    Route::get('/tracer-periods/create', TracerPeriodCreate::class)->name('admin.tracer-periods.create');
    Route::get('/tracer-periods/{id}/edit', TracerPeriodEdit::class)->name('admin.tracer-periods.edit');

    // Tracer Question Management
    Route::get('/tracer-questions', TracerQuestionIndex::class)->name('admin.tracer-questions.index');
    Route::get('/tracer-questions/create', TracerQuestionCreate::class)->name('admin.tracer-questions.create');
    Route::get('/tracer-questions/{id}/edit', TracerQuestionEdit::class)->name('admin.tracer-questions.edit');

    // Tracer Option Management
    Route::get('/tracer-options', TracerOptionIndex::class)->name('admin.tracer-options.index');
    Route::get('/tracer-options/create', TracerOptionCreate::class)->name('admin.tracer-options.create');
    Route::get('/tracer-options/{id}/edit', TracerOptionEdit::class)->name('admin.tracer-options.edit');

    // Tracer Statistics
    Route::get('/tracer-statistics', \App\Livewire\Admin\Tracer\TracerStatistics::class)->name('admin.tracer-statistics');
});

// Admin Only: User Management Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', \App\Livewire\Admin\User\UserIndex::class)->name('admin.users.index');
    Route::get('/users/create', \App\Livewire\Admin\User\UserCreate::class)->name('admin.users.create');
    Route::get('/users/{id}/edit', \App\Livewire\Admin\User\UserEdit::class)->name('admin.users.edit');
});

// Alumni Routes
Route::middleware(['auth', 'verified', 'role:alumni'])->prefix('alumni')->group(function () {
    Route::get('/tracer-periods', TracerPeriodList::class)->name('alumni.tracer-periods');
    Route::get('/tracer-study/{period_id}', TracerStudyForm::class)->name('alumni.tracer-study');
});

require __DIR__.'/settings.php';

// Override forgot password logic to generate and send a new random password
Route::post('/forgot-password-random', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    $user = \App\Models\User::where('email', $request->email)->first();
    
    if ($user) {
        $newPassword = \Illuminate\Support\Str::random(8);
        $user->password = \Illuminate\Support\Facades\Hash::make($newPassword);
        $user->save();
        
        \Illuminate\Support\Facades\Mail::to($user)->send(new \App\Mail\NewPasswordGenerated($newPassword));
    }

    return back()->with('status', 'Jika email terdaftar, kami telah mengirimkan password baru Anda ke email tersebut. Silakan cek kotak masuk Anda.');
})->name('password.random')->middleware('guest');
