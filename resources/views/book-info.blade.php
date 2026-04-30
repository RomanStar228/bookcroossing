<x-app-layout>
    <div class="min-h-screen bg-[#FDFDFC] py-8">
        <div class="max-w-4xl mx-auto px-6 py-10">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <div>
                    @if($book->cover_image_url)
                        <img src="{{ $book->cover_image_url }}" 
                             class="w-full rounded-3xl shadow-xl" alt="{{ $book->title }}">
                    @else
                        <div class="w-full aspect-[4/3] bg-[#EDEBE4] rounded-3xl flex items-center justify-center text-8xl border border-[#e3e3e0]">
                            <img src="/img/photo_delete.png" alt="">
                        </div>
                    @endif
                </div>

                <!-- Информация о книге -->
                <div class="space-y-5">
                    <div>
                        <h1 class="text-4xl font-semibold text-[#1b1b18] leading-tight">
                            {{ $book->title }}
                        </h1>
                        <p class="text-2xl text-[#706f6c]">
                            {{ $book->author }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @if($book->genre)
                            <span class="bg-[#000000] text-[#ffffff] px-5 py-2 rounded-2xl text-sm font-medium">
                                {{ $book->genre->name }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-medium text-[#1b1b18]">Город</h3>
                        <p class="text-lg">{{ $book->city?->name ?? 'Не указан' }}</p>
                    </div>

                    <div>
                        <h3 class="font-medium text-[#1b1b18]">Улица</h3>
                        <p class="text-[#1b1b18] leading-relaxed">
                            @if($book->location)
                                ул. {{ $book->location }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="font-medium text-[#1b1b18] mb-2">Точное местонахождение</h3>
                        <p class="text-[#1b1b18] leading-relaxed">Точное описание местоположения будет доступно только после бронирования книги</p>
                    </div>

                    <!-- Статус книги с учётом роли пользователя -->
                    <div>
                        @php
                            $displayStatus = $book->status;
                            if (auth()->check() && auth()->id() != $book->owner_id && $book->status == 'Отдаю') {
                                $displayStatus = 'Нужно найти';
                            }
                        @endphp
                        <span class="inline-block px-6 py-3 bg-black text-white rounded-2xl shadow">
                            {{ $displayStatus }}
                        </span>
                    </div>

                    @auth
                        @if(Auth::id() != $book->owner_id && $book->status == 'Отдаю')
                            <form method="POST" action="{{ route('requests.store', $book) }}">
                                @csrf
                                <button class="w-full mt-8 bg-black text-white py-3 rounded-2xl">
                                    Забронировать книгу
                                </button>
                            </form>
                        @elseif(Auth::id() != $book->owner_id)
                            <div class="w-full mt-8 bg-gray-300 text-gray-600 py-3 rounded-2xl text-center">
                                Книга уже забронирована или обменяна
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- БЛОК ОТЗЫВОВ -->
            <div class="mt-16 border-t pt-10">
                <h2 class="text-2xl font-semibold mb-6">Отзывы о книге</h2>

                @if($reviews->count())
                    @foreach($reviews as $review)
                        <div class="bg-gray-50 p-5 rounded-xl mb-4">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-3">
                                    @if($review->reviewer->avatar_url)
                                        <img src="{{ $review->reviewer->avatar_url }}" class="w-8 h-8 rounded-full object-cover">
                                    @endif
                                    <div>
                                        <span class="font-semibold">{{ $review->reviewer->full_name }}</span>
                                        <span class="text-sm text-gray-500 ml-3">{{ $review->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="text-yellow-500">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                            </div>
                            <p class="mt-2">{{ $review->comment ?: 'Без комментария' }}</p>
                        </div>
                    @endforeach
                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <p class="text-gray-500">Пока нет отзывов. Будьте первым!</p>
                @endif
            </div>

            <!-- ФОРМА ОТЗЫВА (только если пользователь может оставить отзыв) -->
            @if(isset($canReview) && $canReview && isset($reviewableRequest))
                <div class="mt-10 p-6 bg-gray-50 rounded-xl">
                    <h3 class="text-xl font-semibold mb-4">Оставить отзыв</h3>
                    <form action="{{ route('reviews.store', $reviewableRequest) }}" method="POST">
                        @csrf
                        <select name="rating" class="w-full mb-3 p-2 border rounded" required>
                            <option value="">Оценка 1-5</option>
                            @for($i=1;$i<=5;$i++) 
                                <option value="{{ $i }}">{{ $i }} ★</option>
                            @endfor
                        </select>
                        <textarea name="comment" rows="3" class="w-full p-2 border rounded mb-3" placeholder="Ваш комментарий..."></textarea>
                        <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg">Отправить</button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>