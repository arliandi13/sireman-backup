<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait untuk mendukung pembuatan instance model dengan factory.
use Illuminate\Database\Eloquent\Model; // Kelas dasar untuk semua model Eloquent.

class Customer extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk mendukung factory.

    protected $table = 'customers'; // Nama tabel di database yang terkait dengan model ini.

    protected $fillable = [
        'name', // Kolom `name` bisa diisi secara massal.
        'email', // Kolom `email` bisa diisi secara massal.
        'password', // Kolom `password` bisa diisi secara massal.
    ];

    // Mengaktifkan timestamps jika tabel memiliki kolom `created_at` dan `updated_at`.
    public $timestamps = true;

    // Jika tabel tidak memiliki kolom timestamps, Anda dapat menonaktifkannya dengan baris berikut:
    // public $timestamps = false;
}
