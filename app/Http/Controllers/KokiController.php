<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class KokiController extends Controller
{
    public function kokiDashboard(Request $request)
    {
        $statusFilter = $request->query('status');
        $searchQuery = $request->query('search');

        $pesananQuery = Pesanan::query();

        if ($statusFilter) {
            $pesananQuery->where('status', $statusFilter);
        }

        if ($searchQuery) {
            $pesananQuery->where(function ($query) use ($searchQuery) {
                $query->where('kode_pesanan', 'like', "%$searchQuery%")
                      ->orWhere('nama_pelanggan', 'like', "%$searchQuery%")
                      ->orWhere('bangku', 'like', "%$searchQuery%")
                      ->orWhere('catatan_tambahan', 'like', "%$searchQuery%")
                      ->orWhere('detail_pesanan', 'like', "%$searchQuery%");
            });
        }

        $pesanan = $pesananQuery->get();

        $statusCounts = [
            'Dalam Antrian' => Pesanan::where('status', 'Dalam Antrian')->count(),
            'Sedang Disiapkan' => Pesanan::where('status', 'Sedang Disiapkan')->count(),
            'Siap Diantar' => Pesanan::where('status', 'Siap Diantar')->count(),
            'Selesai' => Pesanan::where('status', 'Selesai')->count(),
            'Dibatalkan' => Pesanan::where('status', 'Dibatalkan')->count(),
        ];

        $totalPesanan = Pesanan::count();

        return view('dashboard-koki', compact('pesanan', 'statusCounts', 'totalPesanan', 'statusFilter', 'searchQuery'));
    }

    public function updateStatus(Request $request, $kodePesanan)
    {
        // Memvalidasi permintaan
        $request->validate([
            'status' => 'required|in:Dalam Antrian,Sedang Disiapkan,Siap Diantar,Selesai,Dibatalkan',
        ]);

        try {
            DB::table('pesanan')
                ->where('kode_pesanan', $kodePesanan)
                ->update([
                    'status' => $request->input('status'),
                    'updated_at' => now(),
                ]);

            // Alihkan ke dasbor-koki dengan pesan sukses
            return redirect()->route('dashboard-koki')->with('message', 'Status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
