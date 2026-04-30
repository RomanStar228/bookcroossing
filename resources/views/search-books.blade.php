<x-app-layout>
<div class="min-h-screen bg-[#FDFDFC] py-8">
<div class="max-w-7xl mx-auto px-6">

    <!-- Заголовок -->
    <div class="mb-10">
        <h1 class="text-3xl font-semibold text-[#1b1b18]">
            Поиск книг
        </h1>

        <p class="text-[#706f6c] mt-2 text-lg">
            Выберите город и найдите книги для обмена
        </p>
    </div>

    <!-- Фильтр -->
    <form method="GET"
          action="{{ route('search-books') }}"
          class="bg-white border border-[#e3e3e0] rounded-3xl p-8 mb-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Город -->
            <div>
                <label class="block text-sm font-medium text-[#706f6c] mb-2">
                    Город
                </label>

                <select name="city_id"
                        class="w-full bg-[#F8F7F4] border border-[#e3e3e0] rounded-2xl px-6 py-4 focus:outline-none">

                    <option value="">Все города</option>

                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                            {{ request('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Поиск -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-[#706f6c] mb-2">
                    Название книги или автор
                </label>

                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Введите название или автора..."
                        class="w-full bg-[#F8F7F4] border border-[#e3e3e0] rounded-2xl px-6 py-4 focus:outline-none">

                    <button type="submit"
                            class="absolute right-6 top-1/2 -translate-y-1/2 text-xl">
                       <img class="w-[20px]" src="img/search.png" alt="">
                    </button>
                </div>
            </div>

        </div>
    </form>

    <!-- Список книг -->
    <div>

        <h2 class="text-2xl font-semibold text-[#1b1b18] mb-6">
            Найденные книги
            <span class="text-base font-normal text-[#706f6c]">
                ({{ $books->count() }})
            </span>
        </h2>

        @if ($books->isEmpty())

            <div class="text-center py-20 bg-white border border-dashed border-[#e3e3e0] rounded-3xl">
                <p class="text-[#706f6c] text-lg">
                    По вашему запросу ничего не найдено
                </p>
            </div>

        @else

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @foreach ($books as $book)

        <!-- КАРТОЧКА КНИГИ -->
        <a href="{{ route('book.show', $book) }}"
           class="bg-white border border-[#e3e3e0] rounded-3xl overflow-hidden hover:shadow-lg transition-all group block">

            <!-- Обложка -->
            <div class="aspect-[4/3] bg-[#EDEBE4] relative">

                @if ($book->cover_image_url)
                    <img src="{{ $book->cover_image_url }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                @else
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        <img src="/img/photo_delete2.png" alt="">
                    </div>
                @endif

                <!-- Статус -->
                <div class="absolute top-4 right-4 bg-[#1b1b18] text-white text-xs px-4 py-1.5 rounded-2xl">
                    {{ $book->status }}
                </div>
            </div>

            <!-- Информация -->
            <div class="p-5">

                <h3 class="font-semibold text-lg line-clamp-2">
                    {{ $book->title }}
                </h3>

                <p class="text-[#706f6c]">
                    {{ $book->author }}
                </p>

                @if ($book->genre)
                    <span class="mt-3 inline-block bg-[#EDEBE4] text-xs px-3 py-1 rounded-full">
                        {{ $book->genre->name }}
                    </span>
                @endif

                <!-- Город -->
                <div class="mt-4 text-sm text-[#706f6c] ">
                    <span class="flex"><img class="w-[18px] mr-1" src="img/point.png" alt=""> {{ $book->city?->name ?? 'Не указан' }}</span>
                </div>

                <!-- Владелец -->
                <div class="mt-6 pt-5 border-t border-[#e3e3e0] flex justify-between text-sm">

                    <div>
                        от
                        <span class="font-medium text-[#1b1b18]">
                            {{ $book->owner->username
                                ?? $book->owner->full_name
                                ?? 'Пользователь' }}
                        </span>
                    </div>

                    <div class="text-amber-500">
                        ★ {{ number_format($book->owner->rating ?? 0, 1) }}
                    </div>

                </div>

                <!-- ❗ ВАЖНО -->
                <!-- Адрес НЕ показываем до брони -->
                <div class="mt-2 text-xs text-[#acaaa3]">
                    Местонахождение скрыто до бронирования
                </div>

            </div>

        </a>

        @endforeach
        </div>

        @endif

    </div>

</div>
</div>
</x-app-layout>