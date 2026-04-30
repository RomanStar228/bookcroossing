@extends('layouts.admin')

@section('title', 'Управление пользователями')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h2 class="text-xl font-medium text-[#1b1b18] mb-4">Активные пользователи</h2>
        <div class="bg-white rounded-3xl shadow-sm border border-[#e3e3e0] overflow-hidden mb-12">
            <table class="w-full">
                <thead class="bg-[#F8F7F4]">
                    <tr>
                        <th class="px-6 py-4 text-left">Имя</th>
                        <th class="px-6 py-4 text-left">Username</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Город</th>
                        <th class="px-6 py-4 text-left">Рейтинг</th>
                        <th class="px-6 py-4 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e3e0]">
                    @foreach($activeUsers as $user)
                    <tr>
                        <td class="px-6 py-5">{{ $user->full_name }}</td>
                        <td class="px-6 py-5 text-[#706f6c]">@{{ $user->username }}</td>
                        <td class="px-6 py-5">{{ $user->email }}</td>
                        <td class="px-6 py-5">{{ $user->city?->name ?? '—' }}</td>
                        <td class="px-6 py-5">{{ number_format($user->rating, 1) }}</td>
                        <td class="px-6 py-5 text-center">
                            <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button onclick="return confirm('Заблокировать пользователя?')" 
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">
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
                        <td class="px-6 py-5 text-[#706f6c]">@{{ $user->username }}</td>
                        <td class="px-6 py-5">{{ $user->email }}</td>
                        <td class="px-6 py-5 text-center">
                            <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                @csrf
                                @method('PATCH')
                                <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm">
                                    Разблокировать
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection