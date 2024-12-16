<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk koki.
     */
    public function kokiDashboard()
    {
        // Logika tambahan jika diperlukan, misalnya mengambil data tertentu
        $data = [
            'orders' => [], // Contoh: mengambil pesanan dari database
        ];

        return view('dashboard-koki', $data);
    }

    /**
     * Tampilkan halaman dashboard untuk pemilik.
     */
    public function pemilikDashboard()
    {
        // Logika tambahan jika diperlukan, misalnya statistik pendapatan
        $data = [
            'statistics' => [], // Contoh: data statistik untuk pemilik
        ];

        return view('dashboard-pemilik', $data);
    }

    /**
     * Tampilkan halaman dashboard untuk pengguna lainnya.
     */
    public function generalDashboard()
    {
        // Logika tambahan jika diperlukan
        return view('dashboard-general');
    }
    /**
     * Tampilkan halaman laporan keuangan untuk pemilik.
     */
    public function laporanKeuangan()
    {
        // Logika tambahan jika diperlukan, misalnya mengambil data laporan
        $data = [
            'laporan' => [], // Contoh: data laporan keuangan
        ];

        return view('laporankeuangan', $data);
    }
    public function laporanPenjualan()
    {
    // Logika tambahan jika diperlukan, misalnya mengambil data laporan penjualan
    $data = [
        'penjualan' => [], // Contoh: data laporan penjualan
    ];

    // Pastikan ini mengarah langsung ke view yang berada di resources/views/laporanpenjualan.blade.php
    return view('laporanpenjualan', $data);
    }

}
