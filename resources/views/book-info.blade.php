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
                    <h3 class="font-medium text-[#1b1b18] ">Город</h3>
                    <p class="text-lg">{{ $book->city?->name ?? 'Не указан' }}</p>
                </div>

                <div>
                    <h3 class="font-medium text-[#1b1b18] ">Улица</h3>
                    <p class="text-[#1b1b18] leading-relaxed">
                        @if($book->location)
                            ул. {{ $book->location }}
                        @endif
                    </p>
                    <p> Точное описание местоположения будет доступно только после бронирования книги</p>
                </div>
                <div>
                    <h3 class="font-medium text-[#1b1b18] mb-2">Точное местонахождение</h3>
                    <p class="text-[#1b1b18] leading-relaxed"> Точное описание местоположения будет доступно только после бронирования книги</p>
                </div>

                
                @auth
@if(Auth::id() != $book->owner_id)

<form method="POST" action="{{ route('requests.store', $book) }}">
    @csrf
    <button class="w-full mt-8 bg-black text-white py-3 rounded-2xl">
         Забронировать книгу 
    </button>
</form>

@endif
@endauth

            </div>
        </div>
    </div>
    </div>
</x-app-layout>