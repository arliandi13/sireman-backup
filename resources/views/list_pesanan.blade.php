<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .table {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: #0d6efd;
            color: white;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }

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
        .btn-status {
        border-radius: 20px; /* Membuat tombol berbentuk oval */
        font-weight: bold;   /* Memberikan teks yang tebal */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-status i {
        margin-right: 5px; /* Memberikan jarak antara ikon dan teks */
    }

    .btn-status.active {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Efek bayangan pada tombol aktif */
        transform: scale(1.05); /* Efek pembesaran pada tombol aktif */
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
        <h1 class="my-4">List Pesanan</h1>
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
                        @if(session('user') && session('user')->role === 'kasir')
                            <th>Aksi</th>
                        @endif
                        @if(session('user') && session('user')->role === 'koki')
                            <th>Detail</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan as $pesan)
                        @if($pesan->is_paid === 0)
                        <tr>
                            <td>{{ $pesan->kode_pesanan }}</td>
                            <td>{{ $pesan->nama_pelanggan }}</td>
                            <td>{{ $pesan->catatan_tambahan }}</td>
                            <td style="text-align: left;">
                                <ul>
                                    @php
                                        $items = is_string($pesan->detail_pesanan) ? json_decode($pesan->detail_pesanan, true) : $pesan->detail_pesanan;
                                    @endphp
                                    @foreach($items as $item)
                                        <li>
                                            {{ $item['deskripsi'] ?? 'Unknown' }} - {{ $item['jumlah'] ?? 0 }} x Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
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
                                @if(session('user')->role === 'koki')
                                    <span class="badge
                                        @if($pesan->status == 'Dalam Antrian') bg-primary
                                        @elseif($pesan->status == 'Sedang Disiapkan') bg-warning
                                        @elseif($pesan->status == 'Siap Diantar') bg-success
                                        @elseif($pesan->status == 'Selesai') bg-secondary
                                        @elseif($pesan->status == 'Dibatalkan') bg-danger
                                        @endif">
                                        {{ $pesan->status }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">Belum Dibayar</span>
                                @endif
                            </td>

                            <td>Rp{{ number_format($pesan->total_harga, 0, ',', '.') }}</td>

                            @if(session('user') && session('user')->role === 'kasir')
                            <td>
                                <form action="{{ route('pembayaran.form', $pesan->kode_pesanan) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Bayar</button>
                                </form>
                            </td>
                            @endif

                            @if(session('user') && session('user')->role === 'koki')
                            <td>
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pesan->kode_pesanan }}">Detail</button>
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
                                        <ul>
                                            @foreach($items as $item)
                                            <li>
                                                {{ $item['deskripsi'] ?? 'Unknown' }} - {{ $item['jumlah'] ?? 0 }} x Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                                            </li>
                                            @endforeach
                                        </ul>
                                        <p><strong>Total Harga:</strong> Rp{{ number_format($pesan->total_harga, 0, ',', '.') }}</p>
                                        <p><strong>Status:</strong> Belum Dibayar</p>
                                        <p><strong>Catatan:</strong> {{ $pesan->catatan_tambahan }}</p>

                                        @if(session('user') && session('user')->role === 'koki')
                                        <div class="d-flex gap-2">
                                        <form action="{{ route('update.status', $pesan->kode_pesanan) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                                <button type="submit" name="status" value="Dalam Antrian" class="btn btn-outline-primary {{ $pesan->status == 'Dalam Antrian' ? 'active' : '' }}">
                                                    <div class="d-flex gap-2"></i> Dalam Antrian
                                                </button>

                                                <button type="submit" name="status" value="Sedang Disiapkan" class="btn btn-outline-warning {{ $pesan->status == 'Sedang Disiapkan' ? 'active' : '' }}">
                                                    <i class="fas fa-spinner"></i> Sedang Disiapkan
                                                </button>

                                                <button type="submit" name="status" value="Siap Diantar" class="btn btn-outline-success {{ $pesan->status == 'Siap Diantar' ? 'active' : '' }}">
                                                     <i class="fas fa-utensils"></i> Siap Diantar
                                                </button>

                                                <button type="submit" name="status" value="Selesai" class="btn btn-outline-secondary {{ $pesan->status == 'Selesai' ? 'active' : '' }}">
                                                   <i class="fas fa-clipboard-check"></i> Selesai
                                                </button>

                                                <button type="submit" name="status" value="Dibatalkan" class="btn btn-outline-danger {{ $pesan->status == 'Dibatalkan' ? 'active' : '' }}">
                                                   <i class="fas fa-times-circle"></i> Dibatalkan
                                                </button>
                                            </div>
                                        </form>

                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            @if(session('user') && session('user')->role === 'koki')
            <a href="{{ route('dashboard-koki') }}" class="btn btn-primary">Kembali ke Dashboard Koki</a>
            @elseif (session('user') && session('user')->role === 'kasir')
            <a href="/" class="btn btn-primary">Kembali</a>
            <a href="{{ route('list-pembayaran') }}" class="btn btn-secondary">List Pembayaran</a>
        @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
