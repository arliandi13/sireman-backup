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

    protected $fillable = [
        'kode_pesanan',
        'nama_pelanggan',
        'bangku',
        'is_bawa_pulang',
        'catatan_tambahan',
        'detail_pesanan',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'detail_pesanan' => 'array', // Menyimpan detail pesanan sebagai JSON
    ];
}
