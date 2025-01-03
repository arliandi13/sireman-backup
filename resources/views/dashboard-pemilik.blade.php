<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
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

        .sidebar {
            background-color: #f4f4f4;
            padding: 15px;
            border-right: 1px solid #ddd;
            height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin: 15px 0;
            font-weight: bold;
        }

        .main-content {
            padding: 20px;
        }

        .stats {
            display: flex;
            gap: 15px;
        }

        .card {
            flex: 1;
            text-align: center;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .ratings {
            margin-top: 20px;
            text-align: center;
        }

        .stars {
            font-size: 30px;
            color: gold;
        }

        .btn-sidebar {
            width: 100%;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Dashboard Pemilik</span>
            <div class="d-flex">
                <span class="navbar-text me-3">Hello, {{ session('user')->name }}</span>
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li><a href="{{ route('laporan_keuangan') }}" class="btn btn-warning btn-sidebar">Laporan Keuangan</a></li>
                <li><a href="{{ route('laporan_penjualan') }}" class="btn btn-warning btn-sidebar">Laporan Penjualan</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Stats Section -->
            <div class="stats">
                <div class="card">
                    <h5>Pemasukan Hari Ini</h5>
                    <p><strong>Rp. 2.000.000</strong></p>
                </div>
                <div class="card">
                    <h5>Pemasukan Bulan Ini</h5>
                    <p><strong>Rp. 25.000.000</strong></p>
                </div>
                <div class="card">
                    <h5>Transaksi Hari Ini</h5>
                    <p><strong>100 Orang</strong></p>
                </div>
                <div class="card">
                    <h5>Transaksi Bulan Ini</h5>
                    <p><strong>768 Orang</strong></p>
                </div>
            </div>

            <!-- Ratings Section -->
            <div class="ratings">
                <h5>Rating & Ulasan</h5>
                <div class="stars">★★★★★</div>
            </div>
        </main>
    </div>
</body>
</html>
