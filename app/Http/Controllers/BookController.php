<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\City;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Показываем дашборд с книгами пользователя
     */
    public function index()
    {
        $books = Book::where('owner_id', auth()->id())
                     ->with(['genre', 'city'])   // подгружаем связанные данные
                     ->latest()                  // новые книги сверху
                     ->get();

        return view('dashboard', compact('books'));
    }

    /**
     * Форма добавления книги
     */
    public function create()
    {
        $cities = City::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('books.create', compact('cities', 'genres'));
    }

    /**
     * Сохранение новой книги в базу
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'genre_id'     => 'nullable|exists:genres,id',
            'description'  => 'nullable|string|max:1000',
            'location'     => 'required|string|max:500',           // где спрятана книга
            'city_id'      => 'nullable|exists:cities,id',
            'year'         => 'nullable|integer|min:1800|max:' . date('Y'),
            'condition'    => 'nullable|string|max:100',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'       => 'in:Отдаю,Ищу',
        ]);

        $book = new Book();
        $book->owner_id     = auth()->id();
        $book->title        = $validated['title'];
        $book->author       = $validated['author'];
        $book->genre_id     = $validated['genre_id'] ?? null;
        $book->description  = $validated['description'] ?? null;
        $book->location     = $validated['location'];
        $book->city_id      = $validated['city_id'] ?? auth()->user()->city_id;
        $book->condition    = $validated['condition'] ?? null;
        $book->status       = $validated['status'] ?? 'Отдаю';
        $book->is_public    = true;

        // Сохранение обложки
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image_url = '/storage/' . $path;
        }

        $book->save();

        return redirect()->route('dashboard')
                         ->with('success', 'Книга успешно добавлена в ваш профиль!');
    }
}