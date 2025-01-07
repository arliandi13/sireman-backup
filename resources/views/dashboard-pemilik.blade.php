<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
        }

        .navbar {
            background-color: #ff9800 !important;
            color: white !important;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar .btn {
            color: white;
        }

        .sidebar {
            background-color: #343a40;
            padding: 20px;
            border-right: 1px solid #ddd;
            height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin: 20px 0;
            font-weight: bold;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #ff9800;
        }

        .main-content {
            padding: 30px;
            width: 100%;
        }

        .stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            text-align: center;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h5 {
            font-size: 20px;
            color: #333;
        }

        .card p {
            font-size: 22px;
            font-weight: 600;
            color: #ff9800;
        }

        .ratings {
            margin-top: 30px;
            text-align: center;
        }

        .stars {
            font-size: 40px;
            color: gold;
        }

        .btn-sidebar {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            background-color: #ff9800;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-sidebar:hover {
            background-color: #e68900;
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="brand">
                <img src="{{ asset('images/LogoRm.png') }}" alt="Logo" style="height: 40px;"> <!-- Logo RM -->
                <span class="fw-bold">GOGO!</span>
            </div>
            <div class="actions d-flex">
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
                    <h5>Pemasukan Keuangan</h5>
                    <p><strong>Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></p>
                </div>

                <div class="card">
                    <h5>Transaksi Penjualan</h5>
                    <p><strong>{{ $totalTransaksi }} Orang</strong></p>
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
