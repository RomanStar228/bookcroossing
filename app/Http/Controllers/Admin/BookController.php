<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\City;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $activeBooks = Book::with(['owner', 'genre', 'city'])->latest()->get();
        $deletedBooks = Book::onlyTrashed()->with(['owner', 'genre', 'city'])->latest()->get();

        return view('admin.books.index', compact('activeBooks', 'deletedBooks'));
    }

    public function edit(Book $book)
    {
        $cities = City::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'cities', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'genre_id'    => 'nullable|exists:genres,id',
            'description' => 'nullable|string|max:1000',
            'location'    => 'nullable|string|max:500',
            'city_id'     => 'nullable|exists:cities,id',
            'year'        => 'nullable|integer|min:1800|max:' . date('Y'),
            'condition'   => 'nullable|string|max:100',
            'status'      => 'required|in:Отдаю,Ищу,Забронирована,Обменяна,Найдена',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image_url = '/storage/' . $path;
        }

        $book->fill($validated);
        $book->save();

        return redirect()->route('admin.books.index')
                         ->with('success', 'Книга успешно обновлена');
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