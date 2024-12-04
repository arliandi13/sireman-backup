<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'kode_pembayaran';
    protected $fillable = [
        'kode_pesanan', 'jumlah', 'kembalian', 'metode', 'non_cash_detail', 'authorized'
    ];
}
