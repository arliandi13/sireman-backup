<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $menus = Menu::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where(function ($q) use ($query) {
                $q->where('kode_menu', 'LIKE', '%' . $query . '%')
                  ->orWhere('kategori', 'LIKE', '%' . $query . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $query . '%')
                  ->orWhere('harga', 'LIKE', '%' . $query . '%');
            });
        })->get();

        return view('index', compact('menus'));
    }
}
