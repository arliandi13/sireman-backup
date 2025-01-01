<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pembayaran</title>
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
            border-radius: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-status i {
            margin-right: 5px;
        }

        .btn-status.active {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Dashboard Kasir</span>
        <div class="d-flex">
            <span class="navbar-text me-3">Hello, {{ session('user')->name }}</span>
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="text-center mb-4">Daftar Pembayaran</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Pembayaran</th>
                    <th>Kode Pesanan</th>
                    <th>Jumlah Dibayar</th>
                    <th>Metode Pembayaran</th>
                    <th>Kembalian</th>
                    <th>Waktu Pembayaran</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $pay)
                <tr>
                    <td>{{ $pay->kode_pembayaran }}</td>
                    <td>{{ $pay->kode_pesanan }}</td>
                    <td>Rp {{ number_format($pay->jumlah, 2, ',', '.') }}</td>
                    <td>{{ $pay->metode }}</td>
                    <td>Rp {{ number_format($pay->kembalian, 2, ',', '.') }}</td>
                    <td>{{ $pay->created_at }}</td>
                    <td>
                        {{-- <form action="{{ route('print-pembayaran', $pay->id) }}" method="GET">
                            <button type="submit">Print</button>
                        </form> --}}
                        <button class="btn btn-info btn-sm">Print</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-end">
        <a href="{{ route('pesanan.list-pesanan') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
