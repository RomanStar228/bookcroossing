<x-app-layout>
   

    <div class="min-h-screen bg-[#FDFDFC] py-8">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Заголовок + Кнопка Добавить книгу -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-semibold text-[#1b1b18]">
                        Добро пожаловать, {{ Auth::user()->username ?? Auth::user()->full_name ?? Auth::user()->name }}!
                    </h1>
                    <p class="text-[#706f6c] mt-1 text-lg">
                        Здесь вы можете управлять своими книгами и участвовать в буккроссинге
                    </p>
                </div>

                <a href="{{ route('books.create') }}" 
                   class="inline-flex items-center justify-center bg-[#1b1b18] hover:bg-black transition-colors text-white font-medium px-8 py-4 rounded-2xl text-base shadow-sm">
                    <span class="mr-3 text-2xl leading-none">+</span>
                    Добавить книгу
                </a>
            </div>

            <!-- Поиск и фильтрация -->
            <div class="bg-white border border-[#e3e3e0] rounded-3xl p-8 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-7">
                        <label class="block text-sm font-medium text-[#706f6c] mb-2">Поиск книг</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="search-input"
                                placeholder="Название книги или имя автора..."
                                class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 text-[#1b1b18] placeholder-[#acaaa3] focus:outline-none"
                            >
                            <button class="absolute right-6 top-1/2 -translate-y-1/2 text-[#706f6c] hover:text-[#1b1b18] text-xl">
                                <img  class="w-[30px]" src="img/search.png" alt="">
                            </button>
                        </div>
                    </div>

                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-[#706f6c] mb-2">Жанр</label>
                        <select id="genre-filter" class="w-full bg-[#F8F7F4] border border-[#e3e3e0] focus:border-[#1b1b18] rounded-2xl px-6 py-4 text-[#1b1b18] focus:outline-none">
                            <option value="">Все жанры</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Мои книги -->
            <div>
                <h2 class="text-2xl font-semibold text-[#1b1b18] mb-6">Мои книги</h2>

                <!-- Пустое состояние -->
                <div id="empty-state" class="col-span-full text-center py-20 bg-white border border-dashed border-[#e3e3e0] rounded-3xl">
                    <div class="mx-auto w-24 h-24 bg-[#EDEBE4] rounded-3xl flex items-center justify-center text-6xl mb-6">
                        <img class="w-[70px]" src="img/booksItem.png" alt="">
                    </div>
                    <h3 class="text-[#1b1b18] text-2xl font-medium">У вас пока нет добавленных книг</h3>
                    <p class="text-[#706f6c] mt-3 max-w-sm mx-auto">
                        Добавьте первую книгу, чтобы начать делиться литературой с другими участниками буккроссинга
                    </p>
                    <a href="{{ route('books.create') }}" 
                       class="mt-10 inline-flex items-center bg-[#1b1b18] text-white px-10 py-4 rounded-2xl hover:bg-black transition-colors font-medium">
                        Добавить первую книгу
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>