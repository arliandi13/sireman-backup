<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $menus = \DB::table('menus')->get(); // Ambil semua data menu dari tabel `menus`
        $keranjang = session()->get('keranjang', []); // Ambil keranjang dari sesi
        return view('index', compact('menus', 'keranjang'));
    }

    public function tambahKeKeranjang(Request $request)
    {
        $menuId = $request->input('menu_id');
        $menu = \DB::table('menus')->find($menuId);

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan.');
        }

        $keranjang = session()->get('keranjang', []);
        $keranjang[$menuId] = $keranjang[$menuId] ?? ['menu' => $menu, 'jumlah' => 0];
        $keranjang[$menuId]['jumlah']++;

        session()->put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    public function lihatKeranjang()
    {
        $keranjang = session()->get('keranjang', []);
        $totalHarga = collect($keranjang)->reduce(function ($carry, $item) {
            return $carry + $item['menu']->harga * $item['jumlah'];
        }, 0);

        return view('pesanan', compact('keranjang', 'totalHarga'));
    }

    public function updateKeranjang(Request $request)
    {
        $menuId = $request->input('menu_id');
        $jumlah = $request->input('jumlah');
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$menuId])) {
            if ($jumlah > 0) {
                $keranjang[$menuId]['jumlah'] = $jumlah;
            } else {
                unset($keranjang[$menuId]);
            }
            session()->put('keranjang', $keranjang);
        }

        return redirect()->route('pesanan.keranjang');
    }

    public function simpanPesanan(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'bangku' => 'nullable|required_without:is_bawa_pulang',
            'is_bawa_pulang' => 'nullable|boolean|required_without:bangku',
        ]);

        $keranjang = session()->get('keranjang', []);
        $totalHarga = collect($keranjang)->reduce(function ($carry, $item) {
            return $carry + $item['menu']->harga * $item['jumlah'];
        }, 0);

        $pesanan = Pesanan::create([
            'kode_pesanan' => 'PES-' . time(),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'bangku' => $request->input('bangku'),
            'is_bawa_pulang' => $request->input('is_bawa_pulang') ? 1 : 0,
            'detail_pesanan' => json_encode($keranjang),
            'total_harga' => $totalHarga,
            'status' => 'Dalam Antrian',
        ]);

        session()->forget('keranjang');
        return redirect()->route('pesanan.list')->with('success', 'Pesanan berhasil disimpan.');
    }

    public function listPesanan()
    {
        $pesanan = Pesanan::all();
        return view('list_pesanan', compact('pesanan'));
    }
}
