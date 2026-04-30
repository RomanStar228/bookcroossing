<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-панель - BookCrosser</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>
<body class="bg-[#F8F7F4] font-sans">

    <div class="flex h-screen overflow-hidden">
        <!-- Боковое меню -->
        <div class="w-72 bg-white border-r border-[#e3e3e0] flex flex-col">
            <div class="p-6 border-b border-[#e3e3e0]">
                <img class="w-[60%]" src="/img/logo_2.svg" alt="">
                <p class="text-[#706f6c] text-sm">Административная панель</p>
            </div>

            <nav class="flex-1 p-6 space-y-2">
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-5 py-1 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#1b1b18] text-white' : '' }}">
                    <img class="w-[15%]" src="/img/people.png" alt=""> Управление пользователями
                </a>

                <a href="{{ route('admin.books.index') }}" 
                   class="flex items-center gap-3 px-5 py-2 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.books.*') ? 'bg-[#1b1b18] text-white' : '' }}">
                    <img class="w-[15%]" src="/img/books-stack-of-three.png" alt=""> Управление книгами
                </a>
            </nav>

        </div>

        <!-- Основное содержимое -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Верхняя шапка -->
            <header class="bg-white border-b border-[#e3e3e0] px-8 py-9 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#1b1b18]">@yield('title', 'Админ-панель')</h2>
                
                <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}">
                 @csrf
                    <button type="submit"
                        class="px-7 py-2 mr-4 bg-black text-white rounded-lg hover:bg-white hover:text-black border border-black transition duration-200">
                        Выйти
                    </button>
                </form>
            </div>
            </header>

            <!-- Контент страниц -->
            <main class="flex-1 overflow-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
</html>