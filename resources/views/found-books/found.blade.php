<x-app-layout>
<div class="min-h-screen bg-[#FDFDFC] py-8">
<div class="max-w-7xl mx-auto px-6">

    <div class="mb-10">
        <h1 class="text-3xl font-semibold text-[#1b1b18]">
            Найденные книги
        </h1>
        <p class="text-[#706f6c] mt-2 text-lg">
            Книги, которые уже нашли своих читателей
        </p>
    </div>

    @if ($books->isEmpty())
        <div class="text-center py-20 bg-white border border-dashed border-[#e3e3e0] rounded-3xl">
            <p class="text-[#706f6c] text-lg">Пока нет найденных книг</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($books as $book)
                <a href="{{ route('found-books.show', $book) }}"
                   class="bg-white border border-[#e3e3e0] rounded-3xl overflow-hidden hover:shadow-lg transition-all group block">
                    <!-- Обложка -->
                    <div class="aspect-[4/3] bg-[#EDEBE4] relative">
                        @if ($book->cover_image_url)
                            <img src="{{ $book->cover_image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-7xl">
                                <img src="/img/photo_delete2.png" alt="">
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-[#1b1b18] text-white text-xs px-4 py-1.5 rounded-2xl">
                            {{ $book->status }}
                        </div>
                    </div>
                    <!-- Информация -->
                    <div class="p-5">
                        <h3 class="font-semibold text-lg line-clamp-2">{{ $book->title }}</h3>
                        <p class="text-[#706f6c]">{{ $book->author }}</p>
                        @if ($book->genre)
                            <span class="mt-3 inline-block bg-[#EDEBE4] text-xs px-3 py-1 rounded-full">{{ $book->genre->name }}</span>
                        @endif
                        <div class="mt-4 text-sm text-[#706f6c] flex items-center">
                            <img class="w-[18px] mr-1" src="/img/point.png" alt=""> {{ $book->city?->name ?? 'Не указан' }}
                        </div>
                        <div class="mt-6 pt-5 border-t border-[#e3e3e0] flex justify-between text-sm">
                            <div>от <span class="font-medium">{{ $book->owner->username ?? $book->owner->full_name ?? 'Пользователь' }}</span></div>
                            <div class="text-amber-500">★ {{ number_format($book->reviews_avg_rating ?? 0, 1) }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>
</div>
</x-app-layout>