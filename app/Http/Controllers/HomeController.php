<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    //
    public function index()
    {
        $categories = Category::orderBy('name')->get(['id', 'name', 'description', 'image']);

        return view('home', compact('categories'));
    }
}
