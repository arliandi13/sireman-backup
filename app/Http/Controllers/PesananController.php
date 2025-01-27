<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // Menampilkan menu dan keranjang
    public function index()
    {
        $menus = \DB::table('menus')->get(); // Mengambil semua menu
        $keranjang = session()->get('keranjang', []); // Mengambil keranjang dari sesi
        return view('index', compact('menus', 'keranjang'));
    }

    // Menambahkan menu ke keranjang
    public function tambahKeKeranjang(Request $request)
    {
        $user = session('user');
        $customer = session('customer');

        if (!($customer || ($user && in_array($user->role, ['waiters', 'kasir'])))) {
            abort(403, 'Unauthorized action.');
        }

        $kodeMenu = $request->input('kode_menu');
        $menu = \DB::table('menus')->where('kode_menu', $kodeMenu)->first();

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan.');
        }

        $keranjang = session()->get('keranjang', []);
        $keranjang[$kodeMenu] = $keranjang[$kodeMenu] ?? ['menu' => $menu, 'jumlah' => 0];
        $keranjang[$kodeMenu]['jumlah']++;

        session()->put('keranjang', $keranjang);

        return redirect()->back()
            ->with('success', 'Menu berhasil ditambahkan ke keranjang.')
            ->with('keranjang_debug', session()->get('keranjang'));
    }

    // Melihat keranjang
    public function lihatKeranjang()
    {
        $keranjang = session()->get('keranjang', []);
        $totalHarga = collect($keranjang)->reduce(function ($carry, $item) {
            return $carry + $item['menu']->harga * $item['jumlah'];
        }, 0);

        return view('pesanan', compact('keranjang', 'totalHarga'));
    }

    // Memperbarui keranjang
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

        return redirect()->route('pesanan.keranjang')->with('success', 'Keranjang berhasil diperbarui.');
    }

    // Menyimpan pesanan
    public function simpanPesanan(Request $request)
{
    try {
        // Validasi input
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string', // Nama pelanggan dari input kasir
            'bangku' => 'nullable|required_without:is_bawa_pulang',
            'is_bawa_pulang' => 'nullable|boolean|required_without:bangku',
            'catatan_tambahan' => 'nullable|string',
            'customer_id' => [
                'required_if:role,kasir',
                'exists:customers,id'
            ]
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika user tidak login, redirect ke halaman login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi keranjang
        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        // Ambil nama pelanggan dari customer_id yang dipilih oleh kasir
        $customerId = $request->input('customer_id');
        $namaPelangganDariDB = Customer::where('id', $customerId)->value('name');

        // Jika nama pelanggan tidak ditemukan, gunakan nama dari input
        $namaPelanggan = !empty($namaPelangganDariDB) ? $namaPelangganDariDB : $request->input('nama_pelanggan');

        // Hitung total harga dan detail pesanan
        $detailPesanan = [];
        $totalHarga = 0;
        foreach ($keranjang as $kodeMenu => $item) {
            $detailPesanan[] = [
                'kode_menu' => $item['menu']->kode_menu,
                'deskripsi' => $item['menu']->deskripsi,
                'harga' => $item['menu']->harga,
                'jumlah' => $item['jumlah']
            ];

            $totalHarga += $item['menu']->harga * $item['jumlah'];
        }

        // Simpan pesanan
        Pesanan::create([
            'kode_pesanan' => 'PES-' . time(),
            'customer_id' => $customerId,
            'nama_pelanggan' => $namaPelanggan,  // Menggunakan nama pelanggan yang diambil di atas
            'bangku' => $request->input('bangku'),
            'is_bawa_pulang' => (bool)$request->input('is_bawa_pulang'),
            'catatan_tambahan' => $request->input('catatan_tambahan'),
            'detail_pesanan' => json_encode($detailPesanan),
            'total_harga' => $totalHarga,
            'status' => 'Dalam Antrian',
        ]);

        // Bersihkan keranjang
        session()->forget('keranjang');

        return redirect()->route('pesanan.list-pesanan')->with('success', 'Pesanan berhasil disimpan.');
    } catch (\Exception $e) {
        \Log::error('Kesalahan Simpan Pesanan: ' . $e->getMessage()); // Logging untuk debugging
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pesanan.');
    }
}




    // Menampilkan daftar pesanan
    public function listPesanan()
{
    // Ambil customer ID dari sesi (untuk pelanggan)
    $customerId = session('customer') ? session('customer')->id : null;

    // Ambil user yang sedang login
    $user = session('user');

    // Cek apakah user adalah pelanggan
    if ($customerId) {
        // Jika customer login, tampilkan pesanan milik pelanggan tersebut yang belum dibayar
        $pesanan = Pesanan::where('customer_id', $customerId)
                          ->where('is_paid', 0) // Filter untuk hanya menampilkan pesanan yang belum dibayar
                          ->get();
    } elseif ($user) {
        // Jika user login, periksa perannya
        if ($user->role === 'kasir' || $user->role === 'koki') {
            // Jika user dengan role 'kasir' atau 'koki' login, tampilkan semua pesanan yang belum dibayar
            $pesanan = Pesanan::where('is_paid', 0)->get(); // Filter untuk hanya menampilkan pesanan yang belum dibayar
        } else {
            // Jika user tidak memiliki peran yang valid, arahkan ke halaman login atau halaman lain
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses untuk melihat daftar pesanan.');
        }
    } else {
        // Jika tidak memenuhi kondisi, arahkan ke halaman login pelanggan
        return redirect()->route('customer.login')->with('error', 'Silakan login untuk melihat daftar pesanan.');
    }

    return view('list_pesanan', compact('pesanan'));
}




    // Memperbarui status pesanan
    public function updateStatus(Request $request, $kodePesanan)
    {
        $pesanan = Pesanan::where('kode_pesanan', $kodePesanan)->firstOrFail();

         // Validasi status yang diterima dari request
         if (!in_array($request->status, ['Dalam Antrian', 'Diproses', 'Selesai'])) {
             abort(400, "Status tidak valid.");
         }

         // Update status pesanan dan simpan perubahan ke database
         if ($pesanan) {
             $pesanan->status = request()->status;
             $pesanan->save();
         }

         return back()->with('success', 'Status pesanan berhasil diperbarui!');
     }

     // Menampilkan detail pesanan berdasarkan kode_pesanan
     public function show($kode_pesanan)
     {
         // Mencari pesanan berdasarkan kode_pesanan yang diberikan
         $pesanan = Pesanan::where('kode_pesanan', $kode_pesanan)->first();

         // Jika pesanan tidak ditemukan, tampilkan halaman 404
         if (!$pesanan) {
             abort(404);
         }

         // Hanya kirimkan ke view jika is_paid bernilai 0
         if ($pesanan->is_paid === 0) {
             return view('pesanan.show', compact('pesanan'));
         }

         // Redirect atau tampilkan pesan jika is_paid adalah 1
         return redirect()->route('pesanan.list-pesanan')->with('info', 'Pesanan ini sudah dibayar.');
     }
}
