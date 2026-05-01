<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Вход</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .book-shadow {
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.2), 0 0 0 1px #e3e3e0;
        }
        .page-curve-left {
            background: linear-gradient(90deg, #ffffff 97%, #e3e3e0 100%);
        }
        .page-curve-right {
            background: linear-gradient(270deg, #ffffff 97%, #e3e3e0 100%);
        }
        .page-shadow-left {
            box-shadow: -8px 0 12px -8px rgba(0,0,0,0.1);
        }
        .page-shadow-right {
            box-shadow: 8px 0 12px -8px rgba(0,0,0,0.1);
        }
        .binding-line {
            background: repeating-linear-gradient(90deg, #d4d3ce, #d4d3ce 2px, #e8e7e2 2px, #e8e7e2 8px);
            width: 24px;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased flex items-center justify-center min-h-screen p-6">

<div class="max-w-5xl w-full">
    <!-- Заголовок -->
    <div class="text-center mb-8">
        <a href="/">
            <img src="/img/logo_1.svg" alt="Logo" class="h-12 mx-auto mb-3">
        </a>
        <h2 class="text-3xl font-semibold text-[#1b1b18]">Добро пожаловать</h2>
        <p class="text-[#706f6c] mt-1">Войдите в свой книжный мир</p>
    </div>

    <!-- Книга -->
    <div class="relative flex book-shadow rounded-3xl overflow-hidden bg-white">
        
        <!-- Левая страница: приветствие -->
        <div class="w-1/2 bg-white p-8 page-curve-left page-shadow-left relative z-10 flex flex-col justify-between">
            <div class="mt-12 text-center">
                <div class="mb-4 ml-[45%] "> <img class="w-[30%]" src="/img/books-stack-of-three.png" alt=""></div>
                <h3 class="text-xl font-medium text-[#1b1b18]">Рады видеть вас снова</h3>
                <p class="text-[#706f6c] mt-3 leading-relaxed">
                    Войдите, чтобы продолжить обмениваться книгами, оставлять отзывы и быть частью нашего читательского сообщества.
                </p>
            </div>
            <div class="text-center text-xs text-[#acaaa3] mt-8 pb-4">
                буккроссинг — книги путешествуют
            </div>
            <div class="text-center text-xs text-[#acaaa3] tracking-wider mt-8 pt-4 border-t border-[#e3e3e0]">
                1
            </div>
        </div>

        <!-- Корешок -->
        <div class="binding-line relative z-0"></div>

        <!-- Правая страница: форма входа -->
        <div class="w-1/2 bg-white p-8 page-curve-right page-shadow-right relative z-10">
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1b1b18] mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 bg-[#F8F7F4] border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-[#1b1b18] mb-1">Пароль</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-3 bg-[#F8F7F4] border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm text-[#706f6c]">Запомнить меня</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#706f6c] hover:text-[#1b1b18] underline">
                                Забыли пароль?
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit"
                            class="w-full mb-4 flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#1b1b18] hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                        Войти
                    </button>
                </div>
            </form>
            <div class="text-center text-xs text-[#acaaa3] tracking-wider mt-8 pt-4 border-t border-[#e3e3e0]">
                2 
            </div>
        </div>
    </div>

    <div class="text-center mt-6 text-sm text-[#706f6c]">
        Нет аккаунта? <a href="{{ route('register') }}" class="text-[#1b1b18] font-medium hover:underline">Зарегистрируйтесь</a>
    </div>
</div>

</body>
</html>