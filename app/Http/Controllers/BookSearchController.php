<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pest\Support\View;

class BookSearchController extends Controller
{
    public function index(): View
    {
        return view('serch-books');
    }
}
