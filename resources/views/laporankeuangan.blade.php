<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #ff8c00;
        }
        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .container {
            margin-top: 20px;
        }
        .filter-section {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .filter-section label {
            font-weight: bold;
        }
        table {
            margin-top: 15px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
        }
        table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-explore {
            background-color: #28a745;
            color: #fff;
        }
        .btn-file {
            background-color: #007bff;
            color: #fff;
        }
        .btn-logout {
            background-color: #dc3545;
            color: #fff;
            font-size: 18px;
            border: none;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Header Navbar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Laporan Keuangan</a>
            <a href="#" class="btn btn-logout">⎋</a>
        </div>
    </nav>

    <!-- Container -->
    <div class="container">
        <form action="{{ route('laporan_keuangan') }}" method="GET">
            <div class="filter-section mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tanggal-awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal-awal" name="tanggal_awal" value="{{ request()->get('tanggal_awal') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal-akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal-akhir" name="tanggal_akhir" value="{{ request()->get('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-success me-2">Filter</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table Section -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Pemasukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $pay)
                <tr>
                    <td>{{ $pay->kode_pembayaran }}</td>
                    <td>{{ $pay->created_at->format('d-m-Y') }}</td>
                    <td>{{ 'Pembayaran untuk Pesanan ' . $pay->kode_pesanan }}</td>
                    <td>Rp. {{ number_format($pay->jumlah, 0, ',', '.') }}</td>
                    <td>
                        <button class="btn btn-sm btn-explore">Eksplor</button>
                        <button class="btn btn-sm btn-file">Cetak File</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between mt-3">
        @if(session('user') && session('user')->role === 'pemilik')
            <a href="{{ route('dashboard_pemilik') }}" class="btn btn-primary">Kembali ke Dashboard Pemilik</a>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
