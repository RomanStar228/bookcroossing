<x-app-layout>
<div class="min-h-screen bg-[#FDFDFC] py-8">
<div class="max-w-6xl mx-auto px-6">

    {{-- Заголовок --}}
    <div class="mb-12 text-center">
        <div class="inline-flex items-center gap-3 text-3xl font-semibold text-[#1b1b18]">
            <h1>Обмен книгами</h1>
        </div>
        <p class="text-[#706f6c] mt-2 text-lg">Управляйте запросами и отслеживайте обмены</p>
    </div>

    {{-- 1. МОИ ЗАПРОСЫ --}}
    <div class="mb-16 bg-white border border-[#e3e3e0] rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-6">
                <img class="w-6" src="/img/refresh.png" alt="">
                <h2 class="text-2xl font-medium">Мои запросы</h2>
            </div>

            @forelse($myRequests as $request)
                @continue(!$request->book)
                @php
                    $statusClass = match($request->status) {
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'approved' => 'bg-green-100 text-green-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                    $statusText = match($request->status) {
                        'pending' => 'Ожидание',
                        'approved' => 'Можно забирать',
                        default => $request->status,
                    };
                @endphp
                <div class="border-b border-[#e3e3e0] last:border-0 py-5">
                    <a href="{{ $request->status === 'approved' ? route('book.exchange.show', $request->book) : route('book.show', $request->book) }}"
                       class="block hover:bg-[#F8F7F4] transition rounded-2xl p-3 -m-3">
                        <div class="flex gap-4 items-start">
                            @if($request->book->cover_image_url)
                                <img src="{{ $request->book->cover_image_url }}" class="w-16 h-20 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-16 h-20 bg-[#EDEBE4] rounded-lg flex items-center justify-center text-2xl">
                                    <img src="/img/photo_delete.png" alt="">
                                </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex flex-wrap justify-between items-start gap-2">
                                    <div>
                                        <h3 class="font-semibold text-lg">{{ $request->book->title }}</h3>
                                        <p class="text-sm text-[#706f6c] mt-1">Автор: {{ $request->book->author }}</p>
                                    </div>
                                    <span class="px-4 py-1.5 rounded-full text-sm font-medium {{ $statusClass }}">{{ $statusText }}</span>
                                </div>
                                <div class="mt-2 text-sm text-[#acaaa3] flex">
                                    <img class="w-4 h-4 mr-1" src="/img/point.png" alt=""> 
                                    @if($request->book->city) {{ $request->book->city->name }} @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="text-center py-10 text-[#706f6c]">У вас пока нет запросов.</div>
            @endforelse
        </div>
    </div>

    {{-- 2. ВХОДЯЩИЕ ЗАПРОСЫ (с кнопкой Отклонить) --}}
    <div class="mb-16 bg-white border border-[#e3e3e0] rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-6">
                <img class="w-6" src="/img/refresh.png" alt="">
                <h2 class="text-2xl font-medium">Запросы к моим книгам</h2>
            </div>

            @forelse($incoming as $request)
                @continue(!$request->book)
                <div class="border-b border-[#e3e3e0] last:border-0 py-5">
                    <div class="flex gap-4 items-start">
                        @if($request->book->cover_image_url)
                            <img src="{{ $request->book->cover_image_url }}" class="w-16 h-20 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-16 h-20 bg-[#EDEBE4] rounded-lg flex items-center justify-center text-2xl">
                                <img src="/img/photo_delete2.png" alt="">
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div>
                                    <p class="text-[#1b1b18]">
                                        <strong class="font-semibold">{{ $request->requester->full_name ?? $request->requester->username }}</strong>
                                        хочет книгу
                                        <strong class="font-semibold">«{{ $request->book->title }}»</strong>
                                    </p>
                                    <p class="text-sm text-[#706f6c] mt-1">Автор: {{ $request->book->author }}</p>
                                </div>
                                @if($request->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('requests.approve', $request) }}">
                                            @csrf
                                            <button class="bg-black text-white px-6 py-2 rounded-2xl hover:bg-gray-800 transition text-sm">
                                                Принять
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('requests.reject', $request) }}">
                                            @csrf
                                            <button class="bg-gray-200 text-gray-800 px-6 py-2 rounded-2xl hover:bg-gray-300 transition text-sm">
                                                Отклонить
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                        {{ $request->status === 'rejected' ? 'Отклонён' : ucfirst($request->status) }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2 text-sm text-[#acaaa3] flex">
                                <img class="w-4 h-4 mr-1" src="/img/point.png" alt=""> 
                                {{ $request->book->city?->name ?? 'Город не указан' }}  
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-[#706f6c]">Нет входящих запросов.</div>
            @endforelse
        </div>
    </div>

    {{-- 3. НАЙДЕННЫЕ КНИГИ --}}
    <div class="bg-white border border-[#e3e3e0] rounded-3xl shadow-sm overflow-hidden">
        <div class="p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-6">
                <img class="w-7" src="/img/done.png" alt="">
                <h2 class="text-2xl font-medium">Найденные книги</h2>
                <span class="text-sm text-[#706f6c]">(успешные обмены)</span>
            </div>

            @forelse($completed as $request)
                @continue(!$request->book)
                <a href="{{ route('book.show', $request->book) }}"
                   class="block border-b border-[#e3e3e0] last:border-0 py-5 hover:bg-[#F8F7F4] transition rounded-2xl p-3 -m-3">
                    <div class="flex gap-4 items-start">
                        @if($request->book->cover_image_url)
                            <img src="{{ $request->book->cover_image_url }}" class="w-16 h-20 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-16 h-20 bg-[#EDEBE4] rounded-lg flex items-center justify-center text-3xl"> 
                                <img src="/img/photo_delete2.png" alt="">
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg">{{ $request->book->title }}</h3>
                            <p class="text-[#706f6c]">{{ $request->book->author }}</p>
                            <div class="mt-2 flex flex-wrap gap-3 text-sm">
                                <span class="flex items-center gap-1"><img class="w-4" src="/img/user.png" alt=""> {{ $request->book->owner->full_name ?? $request->book->owner->username }}</span>
                                <span class="flex items-center gap-1"><img class="w-4" src="/img/point.png" alt=""> {{ $request->book->location ?? '—' }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">✓ Книга успешно получена</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-10 text-[#706f6c]">Пока нет завершённых обменов.</div>
            @endforelse
        </div>
    </div>

</div>
</div>
</x-app-layout>