<x-app-layout>
    <div class="max-w-6xl mx-auto p-8">

        <h1 class="text-3xl font-semibold text-[#1b1b18] mb-10">Обмен</h1>

        <!-- ============================= -->
        <!-- 1. Мои запросы -->
        <!-- ============================= -->
        <h2 class="text-2xl font-medium mb-6">Мои запросы</h2>

        <div class="space-y-4 mb-16">
            @forelse($myRequests as $request)

                {{-- ✅ APPROVED → открывает book-info2 --}}
                @if($request->status === 'approved')
                    <a href="{{ route('book.exchange.show', $request->book) }}"
                       class="block bg-white border border-green-200 rounded-3xl p-6 hover:shadow-lg transition-all group">
                @else
                {{-- ✅ PENDING → обычная страница книги --}}
                    <a href="{{ route('book.show', $request->book) }}"
                       class="block bg-white border border-[#e3e3e0] rounded-3xl p-6 hover:shadow-lg transition-all group">
                @endif

                        <div class="flex justify-between items-start">

                            <div>
                                <h3 class="font-semibold text-lg">
                                    {{ $request->book->title }}
                                </h3>

                                <p class="text-[#706f6c]">
                                    Автор: {{ $request->book->author }}
                                </p>
                            </div>

                            {{-- СТАТУС --}}
                            @if($request->status === 'pending')
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-2xl text-sm font-medium">
                                    Ожидание
                                </span>

                            @elseif($request->status === 'approved')
                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-2xl text-sm font-medium">
                                    Можно забирать
                                </span>
                            @endif

                        </div>

                    </a>

            @empty
                <p class="text-[#706f6c]">
                    У вас пока нет исходящих запросов.
                </p>
            @endforelse
        </div>


        <!-- ============================= -->
        <!-- 2. Входящие запросы -->
        <!-- ============================= -->
        <h2 class="text-2xl font-medium mb-6">Запросы к моим книгам</h2>

        <div class="space-y-4 mb-16">
            @forelse($incoming as $request)

                <div class="bg-white border border-[#e3e3e0] rounded-3xl p-6">

                    <p class="text-lg">
                        Пользователь
                        <strong>
                            {{ $request->requester->full_name ?? $request->requester->username }}
                        </strong>
                        хочет книгу
                        <strong>"{{ $request->book->title }}"</strong>
                    </p>

                    @if($request->status === 'pending')
                        <form method="POST"
                              action="{{ route('requests.approve', $request) }}"
                              class="mt-4 inline">
                            @csrf

                            <button type="submit"
                                class="bg-[#1b1b18] hover:bg-black text-white px-6 py-3 rounded-2xl transition-colors">
                                Принять запрос
                            </button>
                        </form>
                    @endif

                </div>

            @empty
                <p class="text-[#706f6c]">
                    Запросов к вашим книгам пока нет.
                </p>
            @endforelse
        </div>


        <!-- ============================= -->
        <!-- 3. Найденные книги -->
        <!-- ============================= -->
        <h2 class="text-2xl font-medium mb-6 text-green-700">
            Найденные книги
        </h2>

        <div class="space-y-6">

            @forelse($completed as $request)

                <a href="{{ route('book.exchange.show', $request->book) }}"
                   class="block bg-white border border-green-200 rounded-3xl p-7 hover:shadow-lg transition">

                    <div class="flex flex-col md:flex-row gap-6 items-start">

                        {{-- ОБЛОЖКА --}}
                        <div class="flex-shrink-0">
                            @if($request->book->cover_image_url)
                                <img src="{{ $request->book->cover_image_url }}"
                                     class="w-28 h-28 object-cover rounded-2xl shadow-sm">
                            @else
                                <div class="w-28 h-28 bg-[#EDEBE4] rounded-2xl flex items-center justify-center text-5xl">
                                    <img src="/img/photo_delete.png" alt="">
                                </div>
                            @endif
                        </div>

                        {{-- ИНФОРМАЦИЯ --}}
                        <div class="flex-1">

                            <h3 class="text-xl font-semibold">
                                {{ $request->book->title }}
                            </h3>

                            <p class="text-[#706f6c]">
                                {{ $request->book->author }}
                            </p>

                            <div class="mt-4 space-y-2">

                                <div>
                                    <span class="text-sm text-[#706f6c]">Владелец:</span>
                                    <span class="font-medium ml-2">
                                        {{ $request->book->owner->full_name ?? $request->book->owner->username }}
                                    </span>
                                </div>

                                <div class="text-sm text-[#1b1b18]">
                                    ул. {{ $request->book->location ?? '—' }}
                                </div>

                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-2xl text-sm font-medium">
                                    ✓ Книга успешно получена
                                </span>
                                

                            </div>

                        </div>

                    </div>

                </a>

            @empty
                <div class="bg-white border border-dashed border-[#e3e3e0] rounded-3xl p-12 text-center">
                    <p class="text-[#706f6c]">
                        Пока нет завершённых обменов
                    </p>
                </div>
            @endforelse

        </div>

    </div>
</x-app-layout>