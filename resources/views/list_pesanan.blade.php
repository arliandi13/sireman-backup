<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang abu-abu muda */
        }
        .container {
            margin-top: 50px;
        }
        .table {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            border-radius: 8px; /* Sudut membulat */
            overflow: hidden; /* Mencegah bayangan keluar dari border radius */
        }
        .table th {
            background-color: #0d6efd; /* Warna biru Bootstrap untuk header */
            color: white;
            text-align: center; /* Teks di tengah header */
        }
        .table td {
            vertical-align: middle; /* Isi tabel di tengah vertikal */
            text-align: center;
        }
        .table tbody tr:hover {
            background-color: #e9ecef; /* Efek hover abu-abu lebih gelap */
        }

        .btn-success{
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover{
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-info{
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover{
            background-color: #138496;
            border-color: #117a8b;
        }
        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }

        .navbar {
            background-color: #ff9800 !important;
            color: white !important;
        }

        .navbar .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar .btn {
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                @if(session('user')->role === 'koki')
                    Dashboard Koki
                @elseif(session('user')->role === 'kasir')
                    Dashboard Kasir
                @else
                    Dashboard
                @endif
            </span>
            <div class="d-flex">
                <span class="navbar-text me-3">Hello, {{ session('user')->name }}</span>
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="my-4 text-center">List Pesanan</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Catatan Tambahan</th>
                        <th>Detail Pesanan</th>
                        <th>No Meja</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        @if(session('user') && session('user')->role === 'koki')
                        <th>Detail</th>
                        @endif
                        @if(session('user') && session('user')->role === 'kasir')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan as $pesan)
                    <tr>
                        <td>{{ $pesan->kode_pesanan }}</td>
                        <td>{{ $pesan->nama_pelanggan }}</td>
                        <td>{{ $pesan->catatan_tambahan }}</td>
                        <td style="text-align: left;">
                            <ul>
                                @php
                                    $items = is_string($pesan->detail_pesanan)
                                        ? json_decode($pesan->detail_pesanan, true)
                                        : $pesan->detail_pesanan;
                                @endphp
                                @foreach($items as $item)
                                <li>
                                    {{ $item['deskripsi'] ?? 'Unknown' }} -
                                    {{ $item['jumlah'] ?? 0 }} x Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($pesan->is_bawa_pulang)
                                Bawa Pulang
                            @elseif(!empty($pesan->bangku))
                                Nomor Meja: {{ $pesan->bangku }}
                            @else
                                Tidak Diketahui
                            @endif
                        </td>
                        <td>
                            @if(session('user') && session('user')->role === 'koki')
                                <!-- Menampilkan status sebagai teks biasa (tanpa form) -->
                                <span>{{ $pesan->status }}</span>
                            @else
                                <!-- Menampilkan status untuk role lainnya -->
                                {{ $pesan->status }}
                            @endif
                        </td>

                        <td>Rp{{ number_format($pesan->total_harga, 0, ',', '.') }}</td>

                        @if(session('user') && session('user')->role === 'koki')
                        <td>
                            <!-- Tombol untuk membuka modal -->
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pesan->kode_pesanan }}">Detail</button>
                        </td>
                        @endif

                        @if(session('user') && session('user')->role === 'kasir')
                        <td>
                            <form action="{{ route('pembayaran.form', $pesan->kode_pesanan) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-success">Bayar</button>
                            </form>
                        </td>
                        @endif
                    </tr>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="detailModal{{ $pesan->kode_pesanan }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $pesan->kode_pesanan }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $pesan->kode_pesanan }}">Detail Pesanan - {{ $pesan->kode_pesanan }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Menampilkan Detail Pesanan -->
                <ul>
                    @php
                        $items = is_string($pesan->detail_pesanan)
                            ? json_decode($pesan->detail_pesanan, true)
                            : $pesan->detail_pesanan;
                    @endphp
                    @foreach($items as $item)
                    <li>
                        {{ $item['deskripsi'] ?? 'Unknown' }} -
                        {{ $item['jumlah'] ?? 0 }} x Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                    </li>
                    @endforeach
                </ul>
                <p><strong>Total Harga:</strong> Rp{{ number_format($pesan->total_harga, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $pesan->status }}</p>
                <p><strong>Catatan:</strong> {{ $pesan->catatan_tambahan }}</p>

                <!-- Form untuk Mengubah Status -->
                @if(session('user') && session('user')->role === 'koki')
                <form action="{{ route('update.status', $pesan->kode_pesanan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Ubah Status Pesanan</label>
                        <select name="status" class="form-select">
                            <option value="Dalam Antrian" {{ $pesan->status == 'Dalam Antrian' ? 'selected' : '' }}>Dalam Antrian</option>
                            <option value="Sedang Disiapkan" {{ $pesan->status == 'Sedang Disiapkan' ? 'selected' : '' }}>Sedang Disiapkan</option>
                            <option value="Siap Diantar" {{ $pesan->status == 'Siap Diantar' ? 'selected' : '' }}>Siap Diantar</option>
                            <option value="Selesai" {{ $pesan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $pesan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="Disiapkan" {{ $pesan->status == 'Disiapkan' ? 'selected' : '' }}>Disiapkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            @if(session('user') && session('user')->role === 'koki')
                <a href="{{ route('dashboard_koki') }}" class="btn btn-primary">Kembali ke Dashboard Koki</a>
                @elseif (session('user') && session('user')->role === 'kasir')
                <a href="/" class="btn btn-primary">Kembali</a>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
