<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan jika nama tabel berbeda dengan pluralisasi model
    protected $table = 'menus';

    // Tentukan atribut yang dapat diisi (fillable)
    protected $fillable = [
        'kode_menu',
        'kategori',
        'deskripsi',
        'harga',
        'gambar_menu',
    ];
}
