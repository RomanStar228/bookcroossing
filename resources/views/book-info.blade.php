<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-10">

<div class="grid grid-cols-1 md:grid-cols-2 gap-10">

   
    <div>
        @if($book->cover_image_url)
            <img src="{{ $book->cover_image_url }}"
                 class="w-full rounded-3xl shadow">
        @endif
    </div>

    <div>

        <h1 class="text-3xl font-semibold mb-4">
            {{ $book->title }}
        </h1>

        <p class="text-lg text-gray-600 mb-2">
            Автор: {{ $book->author }}
        </p>

        <p class="mb-2">
            Жанр: {{ $book->genre->name ?? 'Не указан' }}
        </p>

        <p class="mb-4">
            Город: {{ $book->city->name ?? 'Не указан' }}
        </p>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Описание</h3>
            <p class="text-gray-700">
                {{ $book->description }}
            </p>
        </div>

        
        <div class="mb-6">
            <span class="px-4 py-2 bg-black text-white rounded-xl">
                {{ $book->status }}
            </span>
        </div>
        @if($book->owner_id !== auth()->id())

<form method="POST"
      action="{{ route('requests.store', $book) }}">
    @csrf

    <button
        class="mt-6 px-6 py-3 bg-green-600 text-white rounded-xl">
        Забронировать книгу
    </button>

</form>

@endif

        
        <div class="bg-gray-100 p-5 rounded-2xl">
            <h3 class="font-semibold mb-2">Местонахождение книги</h3>

            @if($book->status === 'Отдаю')
                <p>
                    Точное местонахождение станет доступно
                    после бронирования книги.
                </p>
            @else
                <p class="font-medium">
                    {{ $book->location }}
                </p>
            @endif
        </div>

    </div>

</div>

</div>

</x-app-layout>