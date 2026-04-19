<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        // Пока просто заглушка — позже добавим сохранение в БД
        dd('Книга успешно добавлена! (пока только заглушка)', $request->all());
    }
}