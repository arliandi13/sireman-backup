<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use \PDF;

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
            'kode_pesanan' => 'required|exists:pesanan,kode_pesanan',
            'jumlah' => 'required|numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'metode' => 'required|in:cash,debit,qr',
            'card_num' => 'required_if:metode,debit|max:255|nullable',
            'exp_date' => 'required_if:metode,debit|date|nullable',
            'zjp_code' => 'required_if:metode,debit|max:255|nullable',
            'pin' => 'required_if:metode,debit|max:255|nullable',
            'authorized_qr' => 'required_if:metode,qr|boolean|nullable',
        ]);

        // Generate kode_pembayaran dengan format PEM-tanggalwaktu
        $kodePembayaran = 'PEM-' . now()->format('YmdHis');

        // Hitung kembalian
        $kembalian = $request->jumlah - $request->total_harga;

        // Simpan pembayaran
        $pembayaran = new Pembayaran();
        $pembayaran->kode_pembayaran = $kodePembayaran;
        $pembayaran->kode_pesanan = $request->kode_pesanan;
        $pembayaran->jumlah = $request->jumlah;
        $pembayaran->kembalian = max(0, $kembalian);
        $pembayaran->metode = $request->metode;

        // Handle metode pembayaran
        if ($request->metode === 'debit') {
            $pembayaran->card_num = $request->card_num;
            $pembayaran->exp_date = $request->exp_date;
            $pembayaran->zjp_code = $request->zjp_code;
            $pembayaran->pin = $request->pin;
        } elseif ($request->metode === 'qr') {
            $pembayaran->authorized_qr = $request->authorized_qr;
        }

        // Menyimpan catatan pembayaran
        $pembayaran->save();

        // Tandai pesanan sebagai telah dibayar
        Pesanan::where('kode_pesanan', $request->kode_pesanan)->update([
            'is_paid' => 1,
            'updated_at' => now()
        ]);

        return redirect()->route('pesanan.list-pesanan')
            ->with('success', 'Pembayaran berhasil diproses dengan Kode Pembayaran: ' . $kodePembayaran);
    }

    public function printPembayaran($kodePembayaran)
{
    try {
        // Ambil data pembayaran berdasarkan kode_pembayaran
        $pembayaran = Pembayaran::where('kode_pembayaran', $kodePembayaran)->first();

        // Cek apakah data pembayaran ditemukan
        if (!$pembayaran) {
            return redirect()->route('pesanan.list-pesanan')->with('error', 'Pembayaran tidak ditemukan.');
        }

        // Ambil data terkait pesanan
        $pesanan = Pesanan::where('kode_pesanan', $pembayaran->kode_pesanan)->first();

        if (!$pesanan) {
            return redirect()->route('pesanan.list-pesanan')->with('error', 'Pesanan tidak ditemukan untuk pembayaran ini.');
        }

        // Mengambil view untuk mencetak PDF
        $pdf = \PDF::loadView('print-pembayaran', compact('pembayaran', 'pesanan'));

        // Men-download file PDF
        return $pdf->download('Pembayaran-' . $pembayaran->kode_pembayaran . '.pdf');
        
    } catch (\Exception $e) {
        \Log::error('Kesalahan saat mencetak pembayaran: ' . $e->getMessage()); // Logging untuk debugging
        return redirect()->route('pesanan.list-pesanan')->with('error', 'Terjadi kesalahan saat mencetak pembayaran: ' . $e->getMessage());
    }
}



    
    public function listPembayaran()
    {
        $pembayaran = Pembayaran::all();

        return view('list-pembayaran', compact('pembayaran'));
    }
}
