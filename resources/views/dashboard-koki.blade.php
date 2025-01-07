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
            margin: 0;
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        .navbar {
            background-color: #ff9800 !important;
            padding: 10px 20px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar .brand img {
            height: 40px;
        }
        .navbar .actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .welcome-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 40px;
            margin: 100px auto;
            max-width: 500px;
        }
        .welcome-card h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .welcome-card p {
            font-size: 16px;
            margin-bottom: 30px;
        }
        .welcome-card img {
            width: 80px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('images/LogoRm.png') }}" alt="Logo"> <!-- Logo RM -->
            <span class="fw-bold">GOGO!</span>
        </div>
        <div class="actions">
            <span class="navbar-text me-3">Hello, {{ session('user')->name }}</span>
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="welcome-card">
        <img src="{{ asset('images/koki.jpg') }}" alt="Chef Icon"> <!-- Chef Icon -->
        <h1>Hai, Koki Hebat!</h1>
        <p>Setiap hari adalah kesempatan untuk menciptakan keajaiban di dapur.</p>
        <a href="{{ route('pesanan.list-pesanan') }}" class="btn">Daftar Pesanan</a>
    </div>
</body>
</html>
