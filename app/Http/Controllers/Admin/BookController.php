<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $activeBooks = Book::with(['owner', 'genre', 'city'])->latest()->get();
        $deletedBooks = Book::onlyTrashed()->with(['owner', 'genre', 'city'])->latest()->get();

        return view('admin.books.index', compact('activeBooks', 'deletedBooks'));
    }

    public function destroy(Book $book)
    {
        $book->delete(); 
        return redirect()->route('admin.books.index')
                         ->with('success', 'Книга успешно удалена');
    }

    public function restore($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();

        return redirect()->route('admin.books.index')
                         ->with('success', 'Книга успешно восстановлена');
    }
}