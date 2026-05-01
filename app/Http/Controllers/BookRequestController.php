<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookRequestController extends Controller
{
    /**
     * Отправка запроса на бронирование
     */
   public function store(Book $book)
{
    // 1. Нельзя бронировать свою книгу
    if ($book->owner_id === Auth::id()) {
        return back()->with('error', 'Нельзя бронировать свою книгу.');
    }

    // 2. Книга должна быть доступна для бронирования
    if ($book->status != 'Отдаю') {
        return back()->with('error', 'Эта книга уже недоступна для бронирования.');
    }

    // 3. Проверка, не отправлял ли пользователь запрос ранее (кроме отклонённых)
    $exists = BookRequest::where('book_id', $book->id)
        ->where('requester_id', Auth::id())
        ->whereIn('status', ['pending', 'approved'])
        ->exists();
    
    if ($exists) {
        return back()->with('error', 'Вы уже отправили запрос на эту книгу или он уже принят.');
    }

    // 4. Проверка, не был ли отклонён предыдущий запрос от этого пользователя
    $rejected = BookRequest::where('book_id', $book->id)
        ->where('requester_id', Auth::id())
        ->where('status', 'rejected')
        ->exists();
    
    if ($rejected) {
        return back()->with('error', 'Извините, вы не можете забронировать книгу, так как пользователь отказал вам в брони.');
    }

    // Создание запроса
    BookRequest::create([
        'book_id'      => $book->id,
        'requester_id' => Auth::id(),
        'status'       => 'pending',
    ]);

    return redirect()
        ->route('requests.index')
        ->with('success', 'Запрос на бронирование отправлен!');
}

    /**
     * Страница "Обмен"
     */
    public function index()
    {
        $userId = Auth::id();

        // мои отправленные запросы
        $myRequests = BookRequest::with(['book', 'book.owner', 'book.genre', 'book.city'])
            ->where('requester_id', $userId)
            ->latest()
            ->get();

        // входящие запросы
        $incoming = BookRequest::with(['book', 'requester'])
            ->whereHas('book', fn($q) => $q->where('owner_id', $userId))
            ->where('status', 'pending')
            ->latest()
            ->get();

        // завершённые обмены
        $completed = BookRequest::with(['book', 'book.owner'])
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhereHas('book', fn($q) => $q->where('owner_id', $userId));
            })
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('requests.index', compact(
            'myRequests',
            'incoming',
            'completed'
        ));
    }

    /**
     * Одобрить запрос
     */
   public function approve(BookRequest $request)
{
    if ($request->book->owner_id !== auth()->id()) {
        abort(403);
    }

    // Отменяем остальные запросы
    BookRequest::where('book_id', $request->book_id)
        ->where('id', '!=', $request->id)
        ->update(['status' => 'rejected']);

    // Завершаем обмен
    $request->status = 'completed';
    $request->save();

    // Статус книги – «Найдена»
    $book = $request->book;
    $book->status = 'Найдена';   // ← было 'Можно забирать'
    $book->save();

    return redirect()->route('requests.index')
        ->with('success', 'Обмен подтверждён! Книга найдена.');
}

    /**
     * Отклонить запрос
     */
    public function reject(BookRequest $request)
    {
        if ($request->book->owner_id !== Auth::id()) {
            return back()->with('error', 'У вас нет прав.');
        }

        $request->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Запрос отклонён.');
    }

    /**
     * ✅ САМАЯ ВАЖНАЯ ЧАСТЬ — завершение обмена
     */
    public function complete(BookRequest $request)
{
    if ($request->requester_id !== auth()->id()) {
        abort(403);
    }

    $request->status = 'completed';
    $request->save();

    // Меняем статус книги для владельца
    $book = $request->book;
    $book->status = 'Найдена';
    $book->save();

    return redirect()->route('requests.index')->with('success', 'Обмен успешно завершён!');
}
}