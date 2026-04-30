<?php

// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\BookRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, BookRequest $bookRequest)
    {
        // Проверка прав
        if (!$bookRequest->canLeaveReview(Auth::user())) {
            abort(403, 'Вы не можете оставить отзыв к этому обмену.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

       $revieweeId = Auth::id() === $bookRequest->requester_id
    ? $bookRequest->book->owner_id   // пишем владельцу книги
    : $bookRequest->requester_id;    // пишем тому, кто запросил

// reviewee_id никогда не будет равен reviewer_id, потому что:
// - если пользователь — requester, то reviewee — owner (другой)
// - если пользователь — owner, то reviewee — requester (другой)

        Review::create([
            'book_request_id' => $bookRequest->id,
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $revieweeId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен.');
    }

    // Показать все отзывы о пользователе (публичная страница)
    public function index(User $user)
    {
        $reviews = $user->receivedReviews()->with('reviewer')->latest()->paginate(10);
        return view('reviews.index', compact('user', 'reviews'));
    }
}