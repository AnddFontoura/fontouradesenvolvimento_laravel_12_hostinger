<?php

use App\Http\Controllers\ContactCategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Administrative area, restricted to users with the "admin" role.
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Contacts
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');

    // Contact notes (ticket-like entries)
    Route::post('/contacts/{contact}/notes', [ContactNoteController::class, 'store'])->name('contacts.notes.store');
    Route::delete('/contacts/{contact}/notes/{note}', [ContactNoteController::class, 'destroy'])->name('contacts.notes.destroy');

    // Contact categories management
    Route::get('/categories', [ContactCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [ContactCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [ContactCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [ContactCategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';
