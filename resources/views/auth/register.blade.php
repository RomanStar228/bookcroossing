<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Регистрация</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .book-shadow {
            box-shadow: 0 25px 40px -12px rgba(0,0,0,0.15), 0 0 0 1px #e3e3e0;
        }
        .page-curve-left {
            background: linear-gradient(90deg, #ffffff 97%, #f5f5f2 100%);
        }
        .page-curve-right {
            background: linear-gradient(270deg, #ffffff 97%, #f5f5f2 100%);
        }
        .page-shadow-left {
            box-shadow: -6px 0 10px -6px rgba(0,0,0,0.05);
        }
        .page-shadow-right {
            box-shadow: 6px 0 10px -6px rgba(0,0,0,0.05);
        }
        .binding-line {
            background: repeating-linear-gradient(90deg, #d4d3ce, #d4d3ce 2px, #e8e7e2 2px, #e8e7e2 8px);
            width: 24px;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased flex items-center justify-center min-h-screen p-6">

<div class="max-w-5xl w-full">
    <!-- Заголовок над книгой -->
    <div class="text-center mb-8">
        <a href="/">
            <img src="/img/logo_1.svg" alt="Logo" class="h-12 mx-auto mb-3">
        </a>
        <h2 class="text-3xl font-semibold text-[#1b1b18]">Откройте новую главу</h2>
        <p class="text-[#706f6c] mt-1">Заполните страницы, чтобы присоединиться к сообществу</p>
    </div>

    <!-- Книга: две страницы -->
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="relative flex book-shadow rounded-3xl overflow-hidden bg-white">
            
            <!-- Левая страница -->
            <div class="w-1/2 bg-white p-8 page-curve-left page-shadow-left relative z-10 flex flex-col">
                <div class="flex-1 space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-[#1b1b18] mb-1">Имя пользователя</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                               class="w-full px-4 py-3 bg-white border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                        @error('username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-[#1b1b18] mb-1">Полное имя</label>
                        <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required
                               class="w-full px-4 py-3 bg-white border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                        @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1b1b18] mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 bg-white border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="text-center text-xs text-[#acaaa3] tracking-wider mt-8 pt-4 border-t border-[#e3e3e0]">
                    1
                </div>
            </div>

            <!-- Корешок -->
            <div class="binding-line relative z-0"></div>

            <!-- Правая страница -->
            <div class="w-1/2 bg-white p-8 page-curve-right page-shadow-right relative z-10 flex flex-col">
                <div class="flex-1 space-y-6">
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-[#1b1b18] mb-1">Город (необязательно)</label>
                        <select name="city_id" id="city_id"
                                class="w-full px-4 py-3 bg-white border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                            <option value="">Выберите город</option>
                            @foreach(\App\Models\City::orderBy('name')->get() as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-[#1b1b18] mb-1">Пароль</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-3 bg-white border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[#1b1b18] mb-1">Подтвердите пароль</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 bg-white border border-[#e3e3e0] rounded-xl focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
                <div class="text-center mt-8">
                    <button type="submit"
                            class="px-8 py-3 bg-[#1b1b18] text-white rounded-full shadow-md hover:bg-black transition-all duration-200 font-medium flex items-center gap-2 mx-auto">
                        <span>Зарегистрироваться</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
                <div class="text-center text-xs text-[#acaaa3] tracking-wider mt-4 pt-4 border-t border-[#e3e3e0]">
                    2
                </div>
            </div>
        </div>
    </form>

    <div class="text-center mt-6 text-sm text-[#706f6c]">
        Уже есть аккаунт? <a href="{{ route('login') }}" class="text-[#1b1b18] font-medium hover:underline">Войдите</a>
    </div>
</div>

</body>
</html>