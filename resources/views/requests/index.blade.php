<x-app-layout>

<div class="max-w-6xl mx-auto p-8">

<h1 class="text-2xl mb-6 font-semibold">
Мои запросы
</h1>

@foreach($myRequests as $request)

<div class="border p-5 rounded-xl mb-4">

<h2>{{ $request->book->title }}</h2>

@if($request->status === 'pending')
<p>⏳ Ожидание подтверждения</p>
@endif

@if($request->status === 'approved')
<p class="text-green-600 font-semibold">
✅ Книгу можно забрать
</p>

<p class="mt-2">
📍 {{ $request->book->location }}
</p>
@endif

</div>

@endforeach



<h1 class="text-2xl mt-10 mb-6 font-semibold">
Запросы к моим книгам
</h1>

@foreach($incoming as $request)

<div class="border p-5 rounded-xl mb-4">

<p>
{{ $request->requester->name }}
хочет книгу
<strong>{{ $request->book->title }}</strong>
</p>

@if($request->status === 'pending')

<form method="POST"
action="{{ route('requests.approve',$request) }}">
@csrf

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Принять
</button>

</form>

@endif

</div>

@endforeach

</div>

</x-app-layout>