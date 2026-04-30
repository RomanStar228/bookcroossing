<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// === Главная страница пользователя (Профиль / Дашборд) ===
Route::get('/dashboard', [BookController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

// === Публичный поиск книг ===
Route::get('/search-books', [BookController::class, 'search'])
     ->name('search-books');

// просмотр книги из поиска
Route::get('/book/{book}', [BookController::class, 'show'])
     ->name('book.show');

// просмотр книги в обмене
// просмотр книги в обмене (book-info2)
Route::get('/exchange/book/{book}', [BookController::class, 'exchangeShow'])
     ->middleware('auth')
     ->name('book.exchange.show');

// === Управление книгами (добавление) ===
Route::middleware('auth')->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])
         ->name('books.create');
    
    Route::post('/books', [BookController::class, 'store'])
         ->name('books.store');
});



// Публичный просмотр отзывов о пользователе
Route::get('/user/{user}/reviews', [ReviewController::class, 'index'])
    ->name('reviews.index');

// Сам store уже есть, но убедитесь, что он внутри auth:
Route::post('/reviews/{bookRequest}', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');



// === Запросы на обмен ===
Route::middleware('auth')->group(function () {

  Route::post('/books/{book}/request', [BookRequestController::class, 'store'])
    ->middleware('auth')
    ->name('requests.store');

    // Страница "Обмен"
    Route::get('/requests', [BookRequestController::class, 'index'])
         ->name('requests.index');

    // Принятие запроса
    Route::post('/requests/{request}/approve', [BookRequestController::class, 'approve'])
         ->name('requests.approve');

    // Отклонить запрос
    Route::post('/requests/{request}/reject', [BookRequestController::class, 'reject'])
         ->name('requests.reject');

    // Завершить обмен (книга найдена)
    Route::post('/requests/{request}/complete', [BookRequestController::class, 'complete'])
         ->name('requests.complete');
});

// === Профиль пользователя ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================== АДМИНИСТРАТИВНАЯ ПАНЕЛЬ ======================
Route::prefix('admin')
     ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
     ->name('admin.')
     ->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.users.index');
    })->name('dashboard');

    // Управление пользователями
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])
         ->name('users.index');

    Route::patch('/users/{user}/ban', [App\Http\Controllers\Admin\UserController::class, 'ban'])
         ->name('users.ban');

    Route::patch('/users/{user}/unban', [App\Http\Controllers\Admin\UserController::class, 'unban'])
         ->name('users.unban');

    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
         ->name('users.destroy');

    // Управление книгами
    Route::get('/books', [App\Http\Controllers\Admin\BookController::class, 'index'])
         ->name('books.index');

    Route::delete('/books/{book}', [App\Http\Controllers\Admin\BookController::class, 'destroy'])
         ->name('books.destroy');

    Route::patch('/books/{book}/restore', [App\Http\Controllers\Admin\BookController::class, 'restore'])
         ->name('books.restore');
});

require __DIR__.'/auth.php';