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
        $totalPemasukan = Pembayaran::sum('jumlah'); // Total pemasukan
        $totalTransaksi = Pembayaran::count(); // Total transaksi

        // Kirim data ke view
        return view('dashboard-pemilik', compact('totalPemasukan', 'totalTransaksi'));
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
    public function laporanPenjualan()
    {
        // Ambil hanya kode pesanan dan detail pesanan dari pesanan yang sudah dibayar (is_paid = 1)
        $pembayaran = Pesanan::where('is_paid', 1)
                             ->select('kode_pesanan', 'detail_pesanan') // Ambil hanya kolom yang diperlukan
                             ->get();

        // Kirim data ke view
        return view('laporanpenjualan', compact('pembayaran'));
    }

    public function index()
    {
        // Ambil semua pembayaran yang sudah dibayar
        $pembayaran = Pembayaran::where('is_paid', 1)->get();

        // Hitung total pemasukan (jumlah pembayaran)
        $totalPemasukan = $pembayaran->sum('jumlah');

        // Ambil jumlah transaksi penjualan
        $totalTransaksi = $pembayaran->count();

        // Kirim data ke view
        return view('dashboard.index', compact('totalPemasukan', 'totalTransaksi'));
    }
}
