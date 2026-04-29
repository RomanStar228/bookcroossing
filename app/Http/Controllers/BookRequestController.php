<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    
    public function store(Book $book)
    {
        
        if ($book->owner_id === auth()->id()) {
            return back()->with('error', 'Нельзя бронировать свою книгу.');
        }

       
        $exists = BookRequest::where('book_id', $book->id)
            ->where('requester_id', auth()->id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'Вы уже отправили запрос.');
        }

        BookRequest::create([
            'book_id' => $book->id,
            'requester_id' => auth()->id(),
        ]);

        return redirect()->route('requests.index')
            ->with('success', 'Запрос отправлен!');
    }

    
    public function index()
    {
        $myRequests = BookRequest::with('book')
            ->where('requester_id', auth()->id())
            ->latest()
            ->get();

        $incoming = BookRequest::whereHas('book', function ($q) {
            $q->where('owner_id', auth()->id());
        })
        ->with(['book', 'requester'])
        ->latest()
        ->get();

        return view('requests.index', compact('myRequests', 'incoming'));
    }

    
    public function approve(BookRequest $request)
    {
        $request->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Запрос одобрен!');
    }
}