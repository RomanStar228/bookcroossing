<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\City;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * ===============================
     * Дашборд пользователя
     * ===============================
     */
   public function index(Request $request)
{
    $query = Book::where('owner_id', Auth::id())
        ->with(['genre', 'city']);

    // Фильтр по поисковому запросу (название или автор)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('author', 'LIKE', "%{$search}%");
        });
    }

    // Фильтр по жанру
    if ($request->filled('genre_id')) {
        $query->where('genre_id', $request->genre_id);
    }

    $books = $query->latest()->get();
    $genres = Genre::orderBy('name')->get();

    return view('dashboard', compact('books', 'genres'));
}

    /**
     * ===============================
     * Форма добавления книги
     * ===============================
     */
    public function create()
    {
        $cities = City::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('books.create', compact('cities', 'genres'));
    }

    /**
     * ===============================
     * Сохранение книги
     * ===============================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'genre_id'    => 'nullable|exists:genres,id',
            'description' => 'nullable|string|max:1000',
            'location'    => 'required|string|max:500',
            'city_id'     => 'nullable|exists:cities,id',
            'year'        => 'nullable|integer|min:1800|max:' . date('Y'),
            'condition'   => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'      => 'in:Отдаю,Ищу',
        ]);

        $book = new Book();

        $book->owner_id    = Auth::id();
        $book->title       = $validated['title'];
        $book->author      = $validated['author'];
        $book->genre_id    = $validated['genre_id'] ?? null;
        $book->description = $validated['description'] ?? null;
        $book->location    = $validated['location'];
        $book->city_id     = $validated['city_id'] ?? Auth::user()->city_id;
        $book->condition   = $validated['condition'] ?? null;
        $book->status      = $validated['status'] ?? 'Отдаю';
        $book->is_public   = true;

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $book->cover_image_url = '/storage/' . $path;
        }

        $book->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Книга успешно добавлена!');

            
    }

    /**
     * ===============================
     * Поиск книг
     * ===============================
     */
    public function search(Request $request)
    {
        $cities = City::orderBy('name')->get();

        $query = Book::where('is_public', true)
            ->where('status', 'Отдаю')   // только доступные для бронирования
            ->with(['genre', 'city', 'owner']);

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%");
            });
        }

        $books = $query->latest()->get();

        return view('search-books', compact('books', 'cities'));
    }

    /**
     * ===============================
     * BOOK-INFO (из поиска)
     * ===============================
     */
   public function show(Book $book)
{
    $book->load(['genre', 'city', 'owner', 'requests']);

    $reviews = $book->reviews()
        ->with('reviewer')
        ->latest()
        ->paginate(5);

    $canReview = false;
    $reviewableRequest = null;

    if (auth()->check()) {
        $reviewableRequest = $book->requests()
            ->where('status', 'completed')
            ->where('requester_id', auth()->id())
            ->whereDoesntHave('reviews', fn($r) => $r->where('reviewer_id', auth()->id()))
            ->first();
        $canReview = (bool) $reviewableRequest;
    }

    // Флаг, может ли пользователь видеть точное местоположение
    $canViewLocation = auth()->check() && $book->canViewLocation(auth()->user());

    return view('book-info', compact('book', 'reviews', 'canReview', 'reviewableRequest', 'canViewLocation'));
}
    /**
     * ===============================
     * BOOK-INFO2 (после принятия обмена / для авторизованных)
     * ===============================
     */
   public function exchangeShow(Book $book)
{
    $book->load(['genre', 'city', 'owner', 'requests']);

    $currentRequest = $book->requests()
        ->where('requester_id', auth()->id())
        ->where('status', 'approved')
        ->first();

    $reviews = $book->reviews()
        ->with('reviewer')
        ->latest()
        ->paginate(5);

    $canReview = false;
    $reviewableRequest = null;

    if (auth()->check()) {
        $reviewableRequest = $book->requests()
            ->where('status', 'completed')
            ->where(function ($q) {
                $q->where('requester_id', auth()->id())
                  ->orWhereHas('book', fn($b) => $b->where('owner_id', auth()->id()));
            })
            ->whereDoesntHave('reviews', fn($r) => $r->where('reviewer_id', auth()->id()))
            ->first();

        $canReview = (bool) $reviewableRequest;
    }

    return view('book-info2', compact('book', 'currentRequest', 'reviews', 'canReview', 'reviewableRequest'));
}

/**
 * Страница "Найденные книги" – список книг со статусом "Обменяна" или "Можно забирать"
 */
public function foundIndex()
{
    $books = Book::where('status', 'Найдена')
        ->with(['genre', 'city', 'owner'])
        ->withAvg('reviews', 'rating')
        ->latest()
        ->get();

    return view('found-books.found', compact('books'));
}

/**
 * Просмотр найденной книги (только чтение, без кнопки бронирования и формы отзыва)
 */
public function foundShow(Book $book)
{
    $book->load(['genre', 'city', 'owner', 'requests']);
    $reviews = $book->reviews()->with('reviewer')->latest()->paginate(5);
    $readonly = true;
    $canViewLocation = auth()->check() && $book->canViewLocation(auth()->user());

    return view('found-books.found-show', compact('book', 'reviews', 'readonly', 'canViewLocation'));
}

/**
 * Форма редактирования книги
 */
public function edit(Book $book)
{
    if ($book->owner_id !== Auth::id()) {
        abort(403);
    }
    $cities = City::orderBy('name')->get();
    $genres = Genre::orderBy('name')->get();
    return view('books.edit', compact('book', 'cities', 'genres'));
}

/**
 * Обновление книги
 */
public function update(Request $request, Book $book)
{
    if ($book->owner_id !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'author'      => 'required|string|max:255',
        'genre_id'    => 'nullable|exists:genres,id',
        'description' => 'nullable|string|max:1000',
        'location'    => 'required|string|max:500',
        'city_id'     => 'nullable|exists:cities,id',
        'year'        => 'nullable|integer|min:1800|max:' . date('Y'),
        'condition'   => 'nullable|string|max:100',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        'status'      => 'in:Отдаю,Ищу',
    ]);

    $book->title       = $validated['title'];
    $book->author      = $validated['author'];
    $book->genre_id    = $validated['genre_id'] ?? null;
    $book->description = $validated['description'] ?? null;
    $book->location    = $validated['location'];
    $book->city_id     = $validated['city_id'] ?? Auth::user()->city_id;
    $book->condition   = $validated['condition'] ?? null;
    $book->status      = $validated['status'] ?? 'Отдаю';

    if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('covers', 'public');
        $book->cover_image_url = '/storage/' . $path;
    }

    $book->save();

    return redirect()->route('dashboard')->with('success', 'Книга успешно обновлена!');
}

    /**
     * ===============================
     * Админ поиск
     * ===============================
     */
    public function adminSearch()
    {
        $cities = City::orderBy('name')->get();

        $books = Book::with(['genre', 'city', 'owner'])
            ->latest()
            ->get();

        return view('search-books', compact('books', 'cities'));
    }
}