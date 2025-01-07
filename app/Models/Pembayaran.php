<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'kode_pembayaran',
        'kode_pesanan',
        'jumlah',
        'kembalian',
        'metode',
        'card_num',
        'exp_date',
        'zjp_code',
        'pin',
        'authorized_debit',
        'qr_code',
        'authorized_qr',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'kode_pesanan', 'kode_pesanan');
    }
}
