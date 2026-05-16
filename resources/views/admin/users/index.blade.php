@extends('layouts.admin')

@section('title', 'Управление пользователями')

@section('content')
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-xl font-medium text-[#1b1b18] mb-4">Активные пользователи</h2>
        <div class="bg-white rounded-3xl shadow-sm border border-[#e3e3e0] overflow-hidden mb-12">
            <table class="w-full">
                <thead class="bg-[#F8F7F4]">
                    <tr>
                        <th class="px-6 py-4 text-left">Настоящее имя</th>
                        <th class="px-6 py-4 text-left">Логин</th>
                        <th class="px-6 py-4 text-left">Почта</th>
                        <th class="px-6 py-4 text-left">Город</th>
                        <th class="px-6 py-4 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e3e0]">
                    @foreach($activeUsers as $user)
                    <tr>
                        <td class="px-6 py-5">{{ $user->full_name }}</td>
                        <td class="px-6 py-5 text-[#706f6c]">{{ $user->username }}</td>
                        <td class="px-6 py-5">{{ $user->email }}</td>
                        <td class="px-6 py-5">{{ $user->city?->name ?? '—' }}</td>
                        <td class="px-6 py-5 text-center">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button onclick="return confirm('Заблокировать пользователя?')" 
                                            class="bg-gray-800 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">
                                        Заблокировать
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Удалить пользователя навсегда?')" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                                        Удалить
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm italic">Вы (нельзя изменить)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="text-xl font-medium text-red-700 mb-4">Заблокированные пользователи</h2>
        <div class="bg-white rounded-3xl shadow-sm border border-[#e3e3e0] overflow-hidden">
            <table class="w-full">
                <thead class="bg-[#F8F7F4]">
                    <tr>
                        <th class="px-6 py-4 text-left">Имя</th>
                        <th class="px-6 py-4 text-left">Username</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e3e0]">
                    @foreach($bannedUsers as $user)
                    <tr>
                        <td class="px-6 py-5">{{ $user->full_name }}</td>
                        <td class="px-6 py-5 text-[#706f6c]">{{ $user->username }}</td>
                        <td class="px-6 py-5">{{ $user->email }}</td>
                        <td class="px-6 py-5 text-center">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm">
                                        Разблокировать
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm italic">Вы (нельзя разблокировать)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection