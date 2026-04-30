<x-app-layout>

<div class="min-h-screen bg-[#FDFDFC] py-10">

<div class="max-w-6xl mx-auto px-6">


<h2 class="text-2xl font-medium mb-6">Мои запросы</h2>

<div class="space-y-5 mb-16">

@forelse($myRequests as $request)

@continue(!$request->book)

@if($request->status === 'approved')
<a href="{{ route('book.exchange.show', $request->book) }}"
   class="block bg-white border border-green-200 rounded-3xl p-6 hover:shadow-lg transition">
@else
<a href="{{ route('book.show', $request->book) }}"
   class="block bg-white border border-gray-200 rounded-3xl p-6 hover:shadow-lg transition">
@endif

<div class="flex justify-between items-start">

<div>
    <h3 class="text-lg font-semibold">
        {{ $request->book->title }}
    </h3>

    <p class="text-[#706f6c]">
        {{ $request->book->author }}
    </p>
</div>

{{-- статус --}}
@if($request->status === 'pending')
<span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-2xl text-sm">
    Ожидание
</span>
@endif

@if($request->status === 'approved')
<span class="px-4 py-2 bg-green-100 text-green-700 rounded-2xl text-sm">
    Можно забирать
</span>
@endif

</div>

</a>

@empty
<p class="text-[#706f6c]">
    У вас пока нет запросов.
</p>
@endforelse

</div>



{{-- ===================================================== --}}
{{-- 2. ВХОДЯЩИЕ --}}
{{-- ===================================================== --}}
<h2 class="text-2xl font-medium mb-6">
    Запросы к моим книгам
</h2>

<div class="space-y-5 mb-16">

@forelse($incoming as $request)

@continue(!$request->book)

<div class="bg-white border border-gray-200 rounded-3xl p-6 flex justify-between">

<p class="text-lg py-7">
Пользователь
<strong>
{{ $request->requester->full_name ?? $request->requester->username }}
</strong>
хочет книгу
<strong>"{{ $request->book->title }}"</strong> 
</p>

@if($request->status === 'pending')

<form method="POST"
      action="{{ route('requests.approve', $request) }}"
      class="mt-4">
@csrf

<button
class="bg-black text-white px-6 py-3 rounded-2xl hover:bg-gray-900 transition">
Принять запрос
</button>

</form>

@endif

</div>

@empty
<p class="text-[#706f6c]">
Нет входящих запросов.
</p>
@endforelse

</div>



{{-- ===================================================== --}}
{{-- 3. НАЙДЕННЫЕ КНИГИ --}}
{{-- ===================================================== --}}
<h2 class="text-2xl font-medium mb-6 text-black-700">
Найденные книги
</h2>

<div class="space-y-6">

@forelse($completed as $request)

@continue(!$request->book)

<a href="{{ route('book.exchange.show', $request->book) }}"
class="block bg-white border border-gray-200 rounded-3xl p-7 hover:shadow-lg transition">

<div class="flex flex-col md:flex-row gap-6">

{{-- обложка --}}
<div class="flex-shrink-0">

@if($request->book->cover_image_url)
<img src="{{ $request->book->cover_image_url }}"
class="w-28 h-40 object-cover rounded-2xl shadow">
@else
<div class="w-28 h-28 bg-[#EDEBE4] rounded-2xl flex items-center justify-center text-5xl">
📖
</div>
@endif

</div>


{{-- инфо --}}
<div class="flex-1">

<h3 class="text-xl font-semibold">
{{ $request->book->title }}
</h3>

<p class="text-[#706f6c]">
{{ $request->book->author }}
</p>

<div class="mt-4 space-y-2">

<div>
<span class="text-sm text-[#706f6c]">Владелец:</span>
<span class="font-medium ml-2">
{{ $request->book->owner->full_name ?? $request->book->owner->username }}
</span>
</div>

<div class="text-sm">
ул. {{ $request->book->location ?? '—' }}
</div>

<span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-2xl text-sm">
 Книга успешно получена
</span>

</div>

</div>

</div>

</a>

@empty

<div class="bg-white border border-dashed rounded-3xl p-12 text-center">
<p class="text-[#706f6c]">
Пока нет завершённых обменов
</p>
</div>

@endforelse

</div>

</div>
</div>

</x-app-layout>