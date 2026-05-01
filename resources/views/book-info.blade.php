<x-app-layout>
<div class="min-h-screen bg-[#FDFDFC] py-8">
<div class="max-w-5xl mx-auto px-6">

    {{-- Заголовок --}}
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-semibold text-[#1b1b18]">Информация о книге</h1>
        <p class="text-[#706f6c] mt-1">Детали и отзывы</p>
    </div>

    {{-- Основная карточка с обложкой и деталями --}}
    <div class="bg-white border border-[#e3e3e0] rounded-3xl shadow-sm overflow-hidden mb-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 lg:p-8">
            {{-- Обложка --}}
            <div class="flex justify-center items-center">
                @if($book->cover_image_url)
                    <img src="{{ $book->cover_image_url }}" class="max-w-full max-h-96 rounded-2xl shadow-md object-contain" alt="{{ $book->title }}">
                @else
                    <div class="w-full max-w-[260px] aspect-[3/4] bg-[#EDEBE4] rounded-2xl flex items-center justify-center text-6xl border border-[#e3e3e0]">
                        <img src="/img/photo_delete.png" alt="">
                    </div>
                @endif
            </div>

            {{-- Детали --}}
            <div class="space-y-5">
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif
                <div>
                    <h1 class="text-3xl font-semibold text-[#1b1b18]">{{ $book->title }}</h1>
                    <p class="text-xl text-[#706f6c]">{{ $book->author }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($book->genre)
                        <span class="inline-block bg-black text-white text-sm px-4 py-1.5 rounded-full">{{ $book->genre->name }}</span>
                    @endif
                    @php
                        $displayStatus = $book->status;
                        if (auth()->check() && auth()->id() != $book->owner_id && $book->status == 'Отдаю') {
                            $displayStatus = 'Нужно найти';
                        }
                    @endphp
                    <span class="inline-block px-5 py-1 bg-black text-white rounded-full text-sm shadow-md">{{ $displayStatus }}</span>
                </div>

                <div class="border-t border-[#e3e3e0] pt-4 space-y-2">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-[#706f6c] w-24">Город:</span>
                        <span class="text-[#1b1b18]">{{ $book->city?->name ?? 'Не указан' }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="text-[#706f6c] w-24">Улица:</span>
                        <span class="text-[#1b1b18]">{{ $book->location ? 'ул. ' . $book->location : '—' }}</span>
                    </div>

                    {{-- ТОЧНОЕ МЕСТОНАХОЖДЕНИЕ — УСЛОВНЫЙ ВЫВОД --}}
                    <div class="mt-2">
                        <div class="flex items-center gap-2 text-[#706f6c] font-medium">
                            <img class="w-5 h-5" src="/img/point.png" alt="">
                            <span>Точное местонахождение:</span>
                        </div>
                        @if(isset($canViewLocation) && $canViewLocation && $book->description)
                            <p class="mt-1 text-[#1b1b18] p-1 ">
                                {{ $book->description }}
                            </p>
                        @else
                            <p class="mt-1 text-sm text-[#acaaa3]">
                                Будет доступно после успешного завершения обмена.
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Кнопка / сообщение --}}
                @auth
                    @if(Auth::id() != $book->owner_id && $book->status == 'Отдаю')
                        <form method="POST" action="{{ route('requests.store', $book) }}">
                            @csrf
                            <button class="w-full bg-black hover:bg-gray-800 text-white py-3 rounded-xl transition-all mt-4">Забронировать книгу</button>
                        </form>
                    @elseif(Auth::id() != $book->owner_id)
                        <div class="w-full bg-gray-100 text-gray-500 py-3 rounded-xl text-center border border-[#e3e3e0] mt-4">Книга уже забронирована или обменяна</div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- Блок отзывов --}}
    <div class="bg-white border border-[#e3e3e0] rounded-3xl shadow-sm overflow-hidden mb-10">
        <div class="p-6 lg:p-8">
            <div class="flex items-center gap-2 mb-6">
                <img class="w-6 h-6" src="/img/massage.png" alt="">
                <h2 class="text-2xl font-medium text-[#1b1b18]">Отзывы</h2>
            </div>

            @if($reviews->count())
                <div class="space-y-5">
                    @foreach($reviews as $review)
                        <div class="bg-[#F8F7F4] p-5 rounded-2xl border border-[#e3e3e0]">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div class="flex items-center gap-3">
                                    @if($review->reviewer->avatar_url)
                                        <img src="{{ $review->reviewer->avatar_url }}" class="w-8 h-8 rounded-full object-cover">
                                    @endif
                                    <div>
                                        <span class="font-semibold text-[#1b1b18]">{{ $review->reviewer->full_name }}</span>
                                        <span class="text-sm text-[#acaaa3] ml-2">{{ $review->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="text-yellow-500 text-lg">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                            </div>
                            <p class="mt-3 text-[#1b1b18]">{{ $review->comment ?: 'Без комментария' }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-8 text-[#706f6c]">Пока нет отзывов. Будьте первым!</div>
            @endif
        </div>
    </div>

    {{-- Форма отзыва (если доступна) --}}
    @if(isset($canReview) && $canReview && isset($reviewableRequest))
        <div class="bg-white border border-[#e3e3e0] rounded-3xl shadow-sm overflow-hidden">
            <div class="p-6 lg:p-8">
                <div class="flex items-center gap-2 mb-4">
                    <h3 class="text-xl font-semibold text-[#1b1b18]">Оставить отзыв</h3>
                </div>
                <form action="{{ route('reviews.store', $reviewableRequest) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-[#1b1b18] mb-1">Оценка</label>
                        <select name="rating" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] rounded-xl px-4 py-2 focus:outline-none focus:ring-1 focus:ring-black" required>
                            <option value="">Выберите оценку 1–5</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}">{{ $i }} ★</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-[#1b1b18] mb-1">Комментарий</label>
                        <textarea name="comment" rows="3" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] rounded-xl px-4 py-2 focus:outline-none focus:ring-1 focus:ring-black" placeholder="Поделитесь впечатлениями..."></textarea>
                    </div>
                    <button type="submit" class="bg-black hover:bg-gray-800 text-white px-6 py-2 rounded-xl transition">Отправить отзыв</button>
                </form>
            </div>
        </div>
    @endif

</div>
</div>
</x-app-layout>