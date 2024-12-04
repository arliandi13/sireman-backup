<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function formPembayaran($kodePesanan)
    {
        $pesanan = Pesanan::where('kode_pesanan', $kodePesanan)->first();

        if (!$pesanan) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('form_pembayaran', compact('pesanan'));
    }

    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'kode_pesanan' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:cash,non-cash',
            'non_cash_detail' => 'nullable|string',
            'authorized' => 'nullable|boolean'
        ]);

        $kembalian = $request->jumlah - $request->total_harga;

        Pembayaran::create([
            'kode_pesanan' => $request->kode_pesanan,
            'jumlah' => $request->jumlah,
            'kembalian' => $kembalian > 0 ? $kembalian : 0,
            'metode' => $request->metode,
            'non_cash_detail' => $request->non_cash_detail,
            'authorized' => $request->authorized,
        ]);

        return redirect()->route('pesanan.list')->with('success', 'Pembayaran berhasil diproses.');
    }
}

