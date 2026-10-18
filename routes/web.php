<?php

use App\Http\Controllers\Admin\InspectionController as AdminInspectionController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InspectionController;
use App\Models\Inspection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::view('/', 'home', ['title' => 'Home'])->name('home');

Route::get('/verified-cars', function () {
    $inspections = Schema::hasTable('inspections')
        ? Inspection::query()
            ->where('status', 'completed')
            ->with('items')
            ->latest('inspected_on')
            ->latest('id')
            ->get()
        : collect();

    return view('pdi.verified', [
        'title' => 'Verified Car Inspections',
        'inspections' => $inspections,
    ]);
})->name('pdi.verified');

Route::view('/about', 'about', ['title' => 'About Us'])->name('about');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/pdi', [InspectionController::class, 'create'])->name('pdi');
Route::post('/pdi/options', [InspectionController::class, 'storeOption'])->name('pdi.options');
Route::post('/pdi/photo', [InspectionController::class, 'uploadPhoto'])
    ->middleware('auth:web')
    ->name('pdi.photo');
Route::post('/pdi', [InspectionController::class, 'store'])
    ->middleware('auth:web')
    ->name('pdi.store');
Route::get('/pdi/{inspection}', [InspectionController::class, 'show'])
    ->name('pdi.show');

Route::middleware('guest:web')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::post('/login/google', [LoginController::class, 'google'])->name('login.google');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('guest:admin')->group(function (): void {
    Route::get('/admin/login', [SessionController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [SessionController::class, 'store'])->name('admin.login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth:web')
    ->name('logout');

Route::post('/admin/logout', [SessionController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('admin.logout');

Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->except(['index']);
    Route::get('inspections', [AdminInspectionController::class, 'index'])->name('inspections.index');
    Route::get('inspections/{inspection}', [AdminInspectionController::class, 'show'])->name('inspections.show');
    Route::put('inspections/{inspection}', [AdminInspectionController::class, 'update'])->name('inspections.update');
    Route::patch('inspections/{inspection}/status', [AdminInspectionController::class, 'updateStatus'])->name('inspections.status');
    Route::put('inspections/{inspection}/items/{itemKey}', [AdminInspectionController::class, 'updateItem'])->name('inspections.items.update');
});
