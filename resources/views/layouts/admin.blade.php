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
                <h1 class="text-2xl font-bold text-[#1b1b18]">BookCrosser</h1>
                <p class="text-[#706f6c] text-sm">Административная панель</p>
            </div>

            <nav class="flex-1 p-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#1b1b18] text-white' : '' }}">
                    🏠 Главная панель
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#1b1b18] text-white' : '' }}">
                    👥 Управление пользователями
                </a>

                <a href="{{ route('admin.books.index') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.books.*') ? 'bg-[#1b1b18] text-white' : '' }}">
                    📚 Управление книгами
                </a>
            </nav>

            <div class="p-6 border-t border-[#e3e3e0]">
                <a href="{{ route('dashboard') }}" 
                   class="text-sm text-[#706f6c] hover:text-[#1b1b18] flex items-center gap-2">
                    ← Вернуться на сайт
                </a>
            </div>
        </div>

        <!-- Основное содержимое -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Верхняя шапка -->
            <header class="bg-white border-b border-[#e3e3e0] px-8 py-5 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#1b1b18]">@yield('title', 'Админ-панель')</h2>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm text-[#706f6c]">Администратор</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="text-red-600 hover:text-red-700 font-medium text-sm">
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
</html><!DOCTYPE html>
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
       
        <div class="w-72 bg-white border-r border-[#e3e3e0] flex flex-col">
            <div class="p-6 border-b border-[#e3e3e0]">
                <h1 class="text-2xl font-bold text-[#1b1b18]">BookCrosser</h1>
                <p class="text-[#706f6c] text-sm">Административная панель</p>
            </div>

            <nav class="flex-1 p-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#1b1b18] text-white' : '' }}">
                     Главная панель
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#1b1b18] text-white' : '' }}">
                     Управление пользователями
                </a>

                <a href="{{ route('admin.books.index') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-2xl text-[#1b1b18] hover:bg-[#F8F7F4] transition-colors {{ request()->routeIs('admin.books.*') ? 'bg-[#1b1b18] text-white' : '' }}">
                     Управление книгами
                </a>
            </nav>

            <div class="p-6 border-t border-[#e3e3e0]">
                <a href="{{ route('dashboard') }}" 
                   class="text-sm text-[#706f6c] hover:text-[#1b1b18] flex items-center gap-2">
                    ← Вернуться на сайт
                </a>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
           
            <header class="bg-white border-b border-[#e3e3e0] px-8 py-5 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-[#1b1b18]">@yield('title', 'Админ-панель')</h2>
                
                <div class="flex items-center gap-4">
                    <span class="text-sm text-[#706f6c]">Администратор</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="text-red-600 hover:text-red-700 font-medium text-sm">
                            Выйти
                        </button>
                    </form>
                </div>
            </header>

           
            <main class="flex-1 overflow-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>