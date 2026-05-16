@extends('layouts.admin')

@section('title', 'Редактировать книгу')

@section('content')

    <div class="max-w-2xl mx-auto px-6">
        <div class="bg-white border border-[#e3e3e0] rounded-3xl p-8">

            <div class="mb-6">
                <h2 class="font-semibold text-3xl text-[#1b1b18]">Редактировать книгу</h2>
                <p class="text-1xl text-[#706f6c] mt-1 max-w-xl">
                    Внесите изменения и поделитесь книгой с сообществом.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    {{-- Название + Автор --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Название книги *</label>
                            <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Автор *</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" required
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                            @error('author') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Жанр + Год --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Жанр</label>
                            <select name="genre_id" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                <option value="">Не указан</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ old('genre_id', $book->genre_id) == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Год издания</label>
                            <input type="number" name="year" min="1800" max="{{ date('Y') }}" value="{{ old('year', $book->year) }}"
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                        </div>
                    </div>

                    {{-- Город + Улица --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Город</label>
                            <select name="city_id" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $book->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Где находится книга *</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-[#acaaa3] pointer-events-none select-none">
                                    ул.
                                </div>
                                <input type="text" name="location" id="location" maxlength="30" required
                                       value="{{ old('location', str_replace('ул. ', '', $book->location)) }}"
                                       placeholder="Богдана Хмельницкого"
                                       class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                                       oninput="this.value = this.value.replace(/^ул\.\s*/, '');">
                            </div>
                            <div class="flex justify-end text-xs mt-1">
                                <span id="location-counter" class="font-medium text-[#706f6c]">{{ mb_strlen(str_replace('ул. ', '', $book->location)) }} / 30</span>
                            </div>
                        </div>
                    </div>

                    {{-- Описание места --}}
                    <div>
                        <label class="block text-sm font-medium text-[#706f6c] mb-2">Описание места</label>
                        <textarea name="description" rows="4" 
                            class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none resize-y"
                            placeholder="Например: под скамейкой в парке Победы, возле кафе 'Книга'...">{{ old('description', $book->description) }}</textarea>
                        <p class="text-xs text-[#acaaa3] mt-1">Опишите точное место, чтобы другой пользователь легко нашёл книгу</p>
                    </div>

                    {{-- Состояние книги + Статус (для администратора) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Состояние книги</label>
                            <input type="text" name="condition" value="{{ old('condition', $book->condition) }}"
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
                                   placeholder="Хорошее, Отличное, Поношенное...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Статус книги</label>
                            <select name="status" required
                                    class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                <option value="Отдаю" {{ old('status', $book->status) == 'Отдаю' ? 'selected' : '' }}>Отдаю</option>
                                <option value="Ищу" {{ old('status', $book->status) == 'Ищу' ? 'selected' : '' }}>Ищу</option>
                                <option value="Забронирована" {{ old('status', $book->status) == 'Забронирована' ? 'selected' : '' }}>Забронирована</option>
                                <option value="Обменяна" {{ old('status', $book->status) == 'Обменяна' ? 'selected' : '' }}>Обменяна</option>
                                <option value="Найдена" {{ old('status', $book->status) == 'Найдена' ? 'selected' : '' }}>Найдена</option>
                            </select>
                        </div>
                    </div>

                    {{-- Обложка (с отображением старой) --}}
                    <div>
                        <label class="block text-sm font-medium text-[#706f6c] mb-2">Обложка книги</label>
                        @if ($book->cover_image_url)
                            <div class="mb-3 flex items-center gap-3">
                                <img src="{{ $book->cover_image_url }}" class="h-16 w-auto rounded-md shadow-sm">
                                <span class="text-xs text-[#706f6c]">Текущая обложка</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-4 flex-wrap">
                            <label for="cover_image" class="cursor-pointer bg-[#1b1b18] hover:bg-black text-white font-medium py-2.5 px-5 rounded-2xl transition-colors shadow-sm">
                                Заменить фото
                            </label>
                            <span id="file-name" class="text-[#706f6c] text-sm">Новое фото не выбрано</span>
                            <input type="file" name="cover_image" id="cover_image" accept="image/*" class="hidden" onchange="updateFileName(this)">
                        </div>
                        @error('cover_image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Кнопки --}}
                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                                class="flex-1 bg-[#1b1b18] hover:bg-black text-white font-medium py-3 rounded-2xl transition-colors">
                            Сохранить изменения
                        </button>
                        <a href="{{ route('admin.books.index') }}" 
                           class="flex-1 border border-[#e3e3e0] hover:bg-[#F8F7F4] text-center font-medium py-3 rounded-2xl transition-colors">
                            Отмена
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('location');
    const counter = document.getElementById('location-counter');

    function updateCounter() {
        let text = input.value;
        if (text.length > 30) {
            input.value = text.substring(0, 30);
        }
        counter.textContent = `${input.value.length} / 30`;
        if (input.value.length >= 25) {
            counter.classList.add('text-orange-600');
        } else {
            counter.classList.remove('text-orange-600');
        }
    }

    if (input) {
        input.addEventListener('input', updateCounter);
        updateCounter();
    }
});

function updateFileName(input) {
    const fileNameSpan = document.getElementById('file-name');
    if (input.files && input.files.length > 0) {
        fileNameSpan.textContent = input.files[0].name;
    } else {
        fileNameSpan.textContent = 'Новое фото не выбрано';
    }
}
</script>
@endsection