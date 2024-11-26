<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'nama_pelanggan',
        'bangku',
        'is_bawa_pulang',
        'detail_pesanan',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'detail_pesanan' => 'array', // Menyimpan detail pesanan sebagai JSON
    ];
}
