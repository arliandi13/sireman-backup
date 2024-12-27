<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran; // Pastikan model Pembayaran digunakan untuk mengambil data dari database
use App\Models\Pesanan; // Jika Anda ingin mengambil data pesanan terkait laporan penjualan

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk koki.
     */
    public function kokiDashboard()
    {
        // Ambil pesanan yang sedang diproses atau baru untuk koki
        $orders = Pesanan::where('status', 'in_progress')->get();

        return view('dashboard-koki', compact('orders'));
    }

    /**
     * Tampilkan halaman dashboard untuk pemilik.
     */
    public function pemilikDashboard()
    {
        // Ambil data statistik untuk pemilik
        $statistics = [
            'totalOrders' => Pesanan::count(), // Total pesanan
            'totalPembayaran' => Pembayaran::sum('jumlah'), // Total pembayaran
        ];

        return view('dashboard-pemilik', compact('statistics'));
    }

    /**
     * Tampilkan halaman dashboard untuk pengguna lainnya.
     */
    public function generalDashboard()
    {
        // Logika tambahan jika diperlukan untuk pengguna umum
        return view('dashboard-general');
    }

    /**
     * Tampilkan halaman laporan keuangan untuk pemilik.
     */
    public function laporanKeuangan(Request $request)
    {
        // Ambil data pembayaran dari database dengan filter tanggal jika ada
        $query = Pembayaran::query();

        // Periksa apakah parameter tanggal_awal dan tanggal_akhir ada
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            // Menggunakan whereBetween untuk filter data berdasarkan rentang tanggal
            $query->whereBetween('created_at', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // Ambil data pembayaran yang sudah difilter
        $pembayaran = $query->get();

        // Hitung total pendapatan
        $totalPendapatan = $pembayaran->sum('jumlah');

        // Format data untuk dikirim ke view
        $data = [
            'pembayaran' => $pembayaran,
            'totalPendapatan' => $totalPendapatan,
        ];

        return view('laporankeuangan', $data);
    }

    /**
     * Tampilkan halaman laporan penjualan untuk pemilik.
     */
    public function laporanPenjualan(Request $request)
    {
        // Ambil data pesanan berdasarkan status dan filter tanggal jika ada
        $query = Pesanan::query();

        // Filter berdasarkan tanggal jika ada
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // Ambil data pesanan yang telah selesai atau yang sedang diproses
        $penjualan = $query->whereIn('status', ['completed', 'paid'])->get();

        // Hitung total penjualan
        $totalPenjualan = $penjualan->sum('total_harga');

        // Format data untuk dikirim ke view
        $data = [
            'penjualan' => $penjualan, // Data laporan penjualan
            'totalPenjualan' => $totalPenjualan, // Total penjualan
        ];

        return view('laporanpenjualan', $data);
    }
}
