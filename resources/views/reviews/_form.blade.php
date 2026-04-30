@if($bookRequest->canLeaveReview(auth()->user()))
    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-medium mb-3">Оставить отзыв</h3>
        <form action="{{ route('reviews.store', $bookRequest) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium">Оценка (1-5)</label>
                <select name="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @for($i=1; $i<=5; $i++)
                        <option value="{{ $i }}">{{ $i }} ★</option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Комментарий (необязательно)</label>
                <textarea name="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg">Отправить отзыв</button>
        </form>
    </div>
@endif