<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Koki</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            background-image: url('https://via.placeholder.com/1200x800?text=Background+Food+Icons');
            background-size: cover;
            background-position: center;
        }

        .welcome-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            margin: 20px auto;
        }

        .welcome-card h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .welcome-card p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .welcome-card .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }

        .welcome-card .btn:hover {
            background-color: #45a049;
        }

        .chef-icon {
            font-size: 50px;
            margin-bottom: 20px;
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
            <span class="navbar-brand mb-0 h1">Dashboard Koki</span>
            <div class="d-flex">
                <span class="navbar-text me-3">Hello, {{ session('user')->name }}</span>
                <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="welcome-card">
        <div class="chef-icon">🍳</div>
        <h1>Hai, Koki Hebat!</h1>
        <p>Setiap hari adalah kesempatan untuk menciptakan keajaiban di dapur.</p>
        <a href="{{ route('pesanan.list-pesanan') }}" class="btn">Daftar Pesanan</a>

    </div>
</body>
</html>
