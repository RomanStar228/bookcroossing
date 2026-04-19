<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome')->with('success', 'User created successfully!');
});

Route::get('/dashboard', [App\Http\Controllers\BookController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Поиск книг
Route::get('/search-books', function () {
    return view('search-books');   // ← вот здесь проблема
})->name('search-books');   // или без name, но middleware auth + verified

// === Книги ===
Route::middleware('auth')->group(function () {
    Route::get('/books/create', [App\Http\Controllers\BookController::class, 'create'])
         ->name('books.create');
    
    Route::post('/books', [App\Http\Controllers\BookController::class, 'store'])
         ->name('books.store');
});

require __DIR__.'/auth.php';
