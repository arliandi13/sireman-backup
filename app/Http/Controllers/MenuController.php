<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all(); // Ambil semua data menu
        return view('index', compact('menus'));
    }
}
