<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetak(Request $request)
    {
        // Mengambil semua data pembayaran tanpa filter tanggal
        $pembayaran = Pembayaran::all();

        // Menambahkan log untuk memeriksa apakah data sudah ada
        \Log::info('Data Pembayaran:', $pembayaran->toArray());

        // Menyiapkan tampilan PDF
        $pdf = PDF::loadView('laporan.print_keuangan', compact('pembayaran'));

        // Mengunduh file PDF
        return $pdf->download('laporan_keuangan_' . now()->format('Y-m-d') . '.pdf');
    }

}
