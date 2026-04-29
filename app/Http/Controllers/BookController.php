<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\City;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    public function index()
{
    $books = Book::where('owner_id', auth()->id())
                 ->with(['genre', 'city'])  
                 ->latest()
                 ->get();

    $genres = \App\Models\Genre::orderBy('name')->get();   

    return view('dashboard', compact('books', 'genres'));
}

   
    public function create()
    {
        $cities = City::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('books.create', compact('cities', 'genres'));
    }


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

        
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image_url = '/storage/' . $path;
        }

        $book->save();

        return redirect()->route('dashboard')
                         ->with('success', 'Книга успешно добавлена в ваш профиль!');
    }

 
public function search(Request $request)
{
    $cities = City::orderBy('name')->get();

    $query = Book::where('is_public', true)
                 ->with(['genre', 'city', 'owner']);

    
    if ($request->filled('city_id')) {
        $query->where('city_id', $request->city_id);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('author', 'LIKE', "%{$search}%");
        });
    }

    $books = $query->latest()->get();

    return view('search-books', compact('books', 'cities'));
}


public function adminSearch()
{
    $cities = City::orderBy('name')->get();

    $books = Book::with(['genre', 'city', 'owner'])
                 ->latest()
                 ->get();  

    return view('search-books', compact('books', 'cities'));
}

public function show(Book $book)
{
    $book->load(['genre', 'city', 'owner']);

    return view('book-info', compact('book'));
}

}

