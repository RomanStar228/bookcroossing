

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





     @if(isset($currentRequest))

    <div class="bg-white p-7 rounded-3xl shadow-lg border mt-10">

    <h3 class="text-xl font-semibold mb-5">
        ⭐ Оставить отзыв
    </h3>

    <form method="POST"
          action="{{ route('reviews.store', $currentRequest) }}"
          class="space-y-4">

        @csrf

        <select name="rating" required
            class="w-full border rounded-xl p-3">

            <option value="">Выберите оценку</option>
            <option value="5">⭐⭐⭐⭐⭐ Отлично</option>
            <option value="4">⭐⭐⭐⭐ Хорошо</option>
            <option value="3">⭐⭐⭐ Нормально</option>
            <option value="2">⭐⭐ Плохо</option>
            <option value="1">⭐ Очень плохо</option>

        </select>

        <textarea name="comment"
            placeholder="Напишите отзыв..."
            class="w-full border rounded-xl p-3 h-28"></textarea>

        <button
            class="w-full bg-black text-white py-3 rounded-2xl">
            Отправить отзыв
        </button>

    </form>

</div>

@endif


    </div>

</div>

</div>
</div>

</x-app-layout>