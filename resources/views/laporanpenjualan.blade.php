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
            <a class="navbar-brand" href="#">Laporan Penjualan</a>
            <a href="#" class="btn btn-logout">⎋</a>
        </div>
    </nav>

    <div class="d-flex justify-content-between mt-3">
        <!-- Cek apakah role pengguna adalah 'koki' -->
        @if(session('user') && session('user')->role === 'pemilik')
            <a href="{{ route('dashboard_pemilik') }}" class="btn btn-primary">Kembali ke Dashboard pemilik</a>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
