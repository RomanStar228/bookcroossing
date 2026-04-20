<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#1b1b18]">Добавить новую книгу</h2>
    </x-slot>

    <div class="min-h-screen bg-[#FDFDFC] py-10">
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-white border border-[#e3e3e0] rounded-3xl p-10">

                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-8">

                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Название книги *</label>
                            <input type="text" name="title" required
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Автор *</label>
                            <input type="text" name="author" required
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-[#706f6c] mb-2">Жанр</label>
                                <select name="genre_id" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                                    <option value="">Не указан</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#706f6c] mb-2">Год издания</label>
                                <input type="number" name="year" min="1800" max="{{ date('Y') }}"
                                       class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                            </div>
                        </div>

                        <!-- Город -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Город</label>
                            <select name="city_id" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" 
                                        {{ old('city_id', Auth::user()->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Место (где спрятана книга) -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">
                               Где находится книга *
                            </label>
    
                        <div class="relative">
                         <div class="absolute left-6 top-4 text-[#acaaa3] pointer-events-none select-none">
                              ул.
                         </div>

                            <textarea name="location" id="location" rows="2"  maxlength="30" required  placeholder="Богдана Хмельницкого" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-14 py-4 focus:outline-none resize-none" oninput="this.value = this.value.replace(/^ул\.\s*/, '');">
                            </textarea>
                    </div>
    
                    <div class="flex justify-end text-xs mt-2">
                         <span id="location-counter" class="font-medium text-[#706f6c]">
                            0 / 20
                         </span>
                    </div>
                </div>

                        <!-- Описание -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Описание места</label>
                            <textarea name="description" rows="4" placeholder="Например: под скамейкой в парке Победы, возле кафе 'Книга' и т.д."
                                class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none resize-y"></textarea>
                                <p class="text-xs text-[#acaaa3] mt-1">Опишите точное место, чтобы другой пользователь легко нашёл книгу</p>
                        </div>

                        <!-- Обложка -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Обложка книги</label>
                            <input type="file" name="cover_image" accept="image/*"
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                        </div>

                        <!-- Кнопки -->
                        <div class="flex gap-4 pt-6">
                            <button type="submit"
                                    class="flex-1 bg-[#1b1b18] hover:bg-black text-white font-medium py-4 rounded-2xl transition-colors">
                                Опубликовать книгу
                            </button>
                            <a href="{{ route('dashboard') }}" 
                               class="flex-1 border border-[#e3e3e0] hover:bg-[#F8F7F4] text-center font-medium py-4 rounded-2xl transition-colors">
                                Отмена
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('location');
    const counter = document.getElementById('location-counter');

    function updateCounter() {
        let text = textarea.value.trim();
        
        // Ограничение ровно 20 символов
        if (text.length > 30) {
            textarea.value = text.substring(0, 30);
        }
        
        counter.textContent = `${textarea.value.length} / 30`;
        
        // Визуальная подсветка
        if (textarea.value.length >= 25) {
            counter.classList.add('text-orange-600');
        } else {
            counter.classList.remove('text-orange-600');
        }
    }

    textarea.addEventListener('input', updateCounter);
    updateCounter(); // инициализация
});
</script>