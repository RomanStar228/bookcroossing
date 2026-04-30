@extends('layouts.admin')

@section('title', 'Управление книгами')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Активные книги -->
        <h2 class="text-xl font-medium mb-6 text-[#1b1b18]">Активные / Опубликованные книги</h2>
        
        <div class="bg-white rounded-3xl border border-[#e3e3e0] overflow-hidden mb-12">
            <table class="w-full">
                <thead class="bg-[#F8F7F4]">
                    <tr>
                        <th class="px-6 py-4 text-left w-16">Обложка</th>
                        <th class="px-6 py-4 text-left">Название книги</th>
                        <th class="px-6 py-4 text-left">Автор</th>
                        <th class="px-6 py-4 text-left">Жанр</th>
                        <th class="px-6 py-4 text-left">Владелец</th>
                        <th class="px-6 py-4 text-left">Город</th>
                        <th class="px-6 py-4 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e3e0]">
                    @forelse($activeBooks as $book)
                    <tr>
                        <td class="px-6 py-4">
                            @if($book->cover_image_url)
                                <img src="{{ $book->cover_image_url }}" 
                                     class="w-14 h-14 object-cover rounded-xl" alt="">
                            @else
                                <div class="w-14 h-14 bg-[#EDEBE4] rounded-xl flex items-center justify-center text-3xl">📖</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $book->title }}</td>
                        <td class="px-6 py-4 text-[#706f6c]">{{ $book->author }}</td>
                        <td class="px-6 py-4">
                            @if($book->genre)
                                <span class="inline-block bg-[#EDEBE4] text-xs px-3 py-1 rounded-full">
                                    {{ $book->genre->name }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $book->owner->full_name ?? $book->owner->username ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $book->city?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-center">
                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Вы уверены, что хотите удалить эту книгу?')" 
                                        class="bg-red-600 hover:bg-red-700 text-white text-sm px-5 py-2 rounded-lg">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-[#706f6c]">
                            Активных книг пока нет
                        </td>
                    </tr>
                    @endempty
                </tbody>
            </table>
        </div>

        <!-- Удалённые книги -->
        <h2 class="text-xl font-medium mb-6 text-black-700">Удалённые книги</h2>
        
        <div class="bg-white rounded-3xl border border-[#e3e3e0] overflow-hidden">
            <table class="w-full">
                <thead class="bg-[#F8F7F4]">
                    <tr>
                        <th class="px-6 py-4 text-left">Название</th>
                        <th class="px-6 py-4 text-left">Автор</th>
                        <th class="px-6 py-4 text-left">Владелец</th>
                        <th class="px-6 py-4 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e3e0]">
                    @forelse($deletedBooks as $book)
                    <tr class="opacity-75">
                        <td class="px-6 py-4 font-medium">{{ $book->title }}</td>
                        <td class="px-6 py-4 text-[#706f6c]">{{ $book->author }}</td>
                        <td class="px-6 py-4">{{ $book->owner->full_name ?? $book->owner->username ?? '—' }}</td>
                        <td class="px-6 py-4 text-center">
                            <form method="POST" action="{{ route('admin.books.restore', $book->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button onclick="return confirm('Восстановить книгу?')" 
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-5 py-2  rounded-lg">
                                    Восстановить
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-[#706f6c]">
                            Удалённых книг пока нет
                        </td>
                    </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
@endsection