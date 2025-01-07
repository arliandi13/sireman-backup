<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda
    protected $table = 'pesanan';

    // Tentukan kolom primary key yang digunakan
    protected $primaryKey = 'kode_pesanan';

    // Nonaktifkan auto-increment karena kode_pesanan bukan integer auto-increment
    public $incrementing = false;

    // Kolom yang bisa diisi
    protected $fillable = [
        'kode_pesanan',
        'customer_id',  // Tambahkan kolom customer_id jika belum ada
        'nama_pelanggan',
        'bangku',
        'is_bawa_pulang',
        'catatan_tambahan',
        'detail_pesanan',
        'total_harga',
        'status',
    ];

    // Casting untuk konversi tipe data, misalnya detail_pesanan sebagai array
    protected $casts = [
        'detail_pesanan' => 'array', // Menyimpan detail pesanan sebagai JSON
        'is_bawa_pulang' => 'boolean',
    ];
}
