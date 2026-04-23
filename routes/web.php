<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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


// Поиск книг (правильный вариант)
Route::get('/search-books', [App\Http\Controllers\BookController::class, 'search'])
     ->name('search-books');

// === Книги ===
Route::middleware('auth')->group(function () {
    Route::get('/books/create', [App\Http\Controllers\BookController::class, 'create'])
         ->name('books.create');
    
    Route::post('/books', [App\Http\Controllers\BookController::class, 'store'])
         ->name('books.store');
});


Route::get('/book/{book}', [BookController::class, 'show'])
    ->name('book.show');

require __DIR__.'/auth.php';
