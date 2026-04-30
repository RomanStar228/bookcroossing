<x-app-layout>
    <div class="min-h-screen bg-[#FDFDFC] py-8">
        <div class="max-w-4xl mx-auto px-6 py-10">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <div>
                    @if($book->cover_image_url)
                        <img src="{{ $book->cover_image_url }}" class="w-full rounded-3xl shadow-xl" alt="{{ $book->title }}">
                    @else
                        <div class="w-full aspect-[4/3] bg-[#EDEBE4] rounded-3xl flex items-center justify-center text-8xl border border-[#e3e3e0]">
                            <img src="/img/photo_delete.png" alt="">
                        </div>
                    @endif
                </div>

                <!-- Информация о книге (без кнопки бронирования) -->
                <div class="space-y-5">
                    <div>
                        <h1 class="text-4xl font-semibold text-[#1b1b18] leading-tight">{{ $book->title }}</h1>
                        <p class="text-2xl text-[#706f6c]">{{ $book->author }}</p>
                    </div>

                    <div>
                         @if($book->genre)
                            <span class="bg-black text-white px-5 py-2 rounded-2xl text-sm font-medium">{{ $book->genre->name }}</span>
                         @endif 
                    </div>

                    <div>
                        <h3 class="font-medium text-[#1b1b18]">Город</h3>
                        <p class="text-lg">{{ $book->city?->name ?? 'Не указан' }}</p>
                    </div>

                    <div>
                        <h3 class="font-medium text-[#1b1b18]">Улица</h3>
                        <p class="text-[#1b1b18]">ул. {{ $book->location ?? 'Не указана' }}</p>
                        <p class="text-xs text-gray-400 mt-3">Точное описание местоположения скрыто</p>
                    </div>
                </div>
            </div>

            <!-- БЛОК ОТЗЫВОВ (только чтение) -->
            <div class="mt-16 border-t pt-10">
                <h2 class="text-2xl font-semibold mb-6">Отзывы о книге</h2>

                @if($reviews->count())
                    @foreach($reviews as $review)
                        <div class="bg-gray-50 p-5 rounded-xl mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-semibold">{{ $review->reviewer->full_name }}</span>
                                    <span class="text-sm text-gray-500 ml-3">{{ $review->created_at->format('d.m.Y') }}</span>
                                </div>
                                <div class="text-yellow-500">
                                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                                </div>
                            </div>
                            <p class="mt-2">{{ $review->comment ?: 'Без комментария' }}</p>
                        </div>
                    @endforeach
                    {{ $reviews->links() }}
                @else
                    <p class="text-gray-500">Пока нет отзывов.</p>
                @endif
            </div>

            <!-- Примечание для пользователя -->
            <div class="mt-8 text-center text-sm text-gray-400">
                Эта книга уже найдена – вы можете только просматривать информацию и отзывы.
            </div>

        </div>
    </div>
</x-app-layout>