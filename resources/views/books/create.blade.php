<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#1b1b18]">Добавить новую книгу</h2>
    </x-slot>

    <div class="min-h-screen bg-[#FDFDFC] py-10">
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-white border border-[#e3e3e0] rounded-3xl p-10">

                <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-8">

                        <!-- Название -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Название книги *</label>
                            <input type="text" name="title" required
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                        </div>

                        <!-- Автор -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Автор *</label>
                            <input type="text" name="author" required
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                        </div>

                        <!-- Жанр + Год -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-[#706f6c] mb-2">Жанр</label>
                                <select name="genre_id" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                                    <option value="">Выберите жанр</option>
                                    <!-- позже заполним из БД -->
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#706f6c] mb-2">Год издания</label>
                                <input type="number" name="year" 
                                       class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                            </div>
                        </div>

                        <!-- Обложка -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Обложка книги</label>
                            <input type="file" name="cover_image" accept="image/*"
                                   class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                        </div>

                        <!-- Статус -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Статус книги</label>
                            <select name="status" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 focus:outline-none">
                                <option value="Отдаю">Отдаю (готов к обмену)</option>
                                <option value="Ищу">Ищу</option>
                            </select>
                        </div>

                        <!-- Город -->
                        <div>
                            <label class="block text-sm font-medium text-[#706f6c] mb-2">Город</label>
                            <input type="text" name="city" value="{{ Auth::user()->city ?? 'Челябинск' }}"
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