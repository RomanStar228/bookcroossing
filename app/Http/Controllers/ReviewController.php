<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, BookRequest $bookRequest)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // ❗ нельзя оставить отзыв дважды
        if (Review::where('book_request_id', $bookRequest->id)
            ->where('reviewer_id', Auth::id())
            ->exists()) {

            return back()->with('error', 'Вы уже оставили отзыв.');
        }

        Review::create([
            'book_request_id' => $bookRequest->id,
            'reviewer_id' => Auth::id(),
            'reviewed_user_id' => $bookRequest->book->owner_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Отзыв успешно добавлен!');
    }
}