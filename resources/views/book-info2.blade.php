

<x-app-layout>

<div class="min-h-screen bg-gradient-to-b from-[#ffffff] to-white">

<div class="max-w-6xl mx-auto px-6 py-12">

<div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">

    <!-- ===================== -->
    <!-- ОБЛОЖКА -->
    <!-- ===================== -->
    <div class="flex justify-center">

        @if ($book->cover_image_url)
                    <img src="{{ $book->cover_image_url }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                @else
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        <img src="/img/photo_delete2.png" alt="">
                    </div>
        @endif

    </div>


    <!-- ===================== -->
    <!-- ИНФОРМАЦИЯ -->
    <!-- ===================== -->
    <div class="space-y-5">

        <!-- Заголовок -->
        <div>
            <h1 class="text-4xl font-semibold text-[#1b1b18] leading-tight">
                {{ $book->title }}
            </h1>

            <p class="text-2xl text-[#706f6c] mt-2">
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
                    <h3 class="font-medium text-[#1b1b18] ">Город</h3>
                    <p class="text-lg">{{ $book->city?->name ?? 'Не указан' }}</p>
                </div>


        <!-- Адрес + описание -->
        
            <h3 class="font-medium mb-3">Местонахождение книги</h3>

            <p class="leading-relaxed text-[#1b1b18]">
                <h3 class="font-medium text-[#1b1b18] ">Улица</h3>
                @if($book->location)
                    ул. {{ $book->location }}
                @endif
                <h3 class="font-medium text-[#1b1b18] ">Точное местонахождение</h3>
                @if($book->description)
                   {{ $book->description }}
                @endif

            </p>
        


        <!-- Статус --> 
        <div>
            <span class="inline-block px-6 py-3 bg-black text-white rounded-2xl shadow">
                {{ $book->status }}
            </span>
        </div>

    </div>

</div>



</div>
<!-- ===================== -->
<!-- ФОРМА ДЛЯ ОТЗЫВА (если можно оставить) -->
<!-- ===================== -->
@if($canReview && $reviewableRequest)
    <div class="mt-10 p-6 bg-gray-50 rounded-xl border border-gray-200">
        <h3 class="text-xl font-semibold mb-4">Оставить отзыв</h3>
        <form action="{{ route('reviews.store', $reviewableRequest) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Оценка</label>
                <select name="rating" class="w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black" required>
                    <option value="">Выберите оценку</option>
                    @for($i=1; $i<=5; $i++)
                        <option value="{{ $i }}">{{ $i }} ★</option>
                    @endfor
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Комментарий (необязательно)</label>
                <textarea name="comment" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black" placeholder="Поделитесь впечатлениями о книге или обмене..."></textarea>
            </div>
            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
                Отправить отзыв
            </button>
        </form>
    </div>
@endif
</div>

</x-app-layout>
 <!-- бронь сделана --> 