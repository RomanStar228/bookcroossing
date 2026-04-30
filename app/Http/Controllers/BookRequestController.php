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
        if ($book->owner_id === Auth::id()) {
            return back()->with('error', 'Нельзя бронировать свою книгу.');
        }

        $exists = BookRequest::where('book_id', $book->id)
            ->where('requester_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Вы уже отправили запрос на эту книгу.');
        }

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
    // только владелец книги
    if ($request->book->owner_id !== auth()->id()) {
        abort(403);
    }

    // ❌ отменяем остальные запросы на эту книгу
    BookRequest::where('book_id', $request->book_id)
        ->where('id', '!=', $request->id)
        ->update(['status' => 'rejected']);

    // ✅ сразу завершаем обмен
    $request->status = 'completed';
    $request->save();

    // ✅ меняем статус книги
    $book = $request->book;
    $book->status = 'Можно забирать';
    $book->save();

    return redirect()
        ->route('requests.index')
        ->with('success', 'Обмен подтверждён! Книгу можно забирать.');
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
        // только тот, кто бронировал книгу
        if ($request->requester_id !== auth()->id()) {
            abort(403);
        }

        // меняем статус
        $request->status = 'completed';
        $request->save();

        return redirect()
            ->route('requests.index')
            ->with('success', 'Обмен успешно завершён!');
    }
}