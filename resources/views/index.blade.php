<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIREMAN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/50" alt="Logo" class="d-inline-block align-text-top">
                Login
            </a>
        </div>
    </nav>

    <!-- Buttons -->
    <div class="container mt-5 text-center">
        <button class="btn btn-primary" id="btn-makanan">Makanan</button>
        <button class="btn btn-secondary" id="btn-minuman">Minuman</button>
    </div>

    <!-- Menu List -->
    <div class="container mt-4">
        <div class="row" id="menu-list">
            @foreach($menus as $menu)
                <div class="col-md-4 mb-3 menu-item {{ $menu->kategori }}">
                    <div class="card">
                        <img
                            src="{{ $menu->gambar_menu }}"
                            class="card-img-top"
                            alt="Gambar {{ $menu->deskripsi }}"
                            style="height: 200px; object-fit: cover;"
                        >
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->deskripsi }}</h5>
                            <p class="card-text">Kode: {{ $menu->kode_menu }}</p>
                            <p class="card-text">Kategori: {{ ucfirst($menu->kategori) }}</p>
                            <p class="card-text">Harga: Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.menu-item').hide(); // Sembunyikan semua menu awalnya

            $('#btn-makanan').click(function () {
                $('.menu-item').hide();
                $('.makanan').show();
            });

            $('#btn-minuman').click(function () {
                $('.menu-item').hide();
                $('.minuman').show();
            });
        });
    </script>
</body>
</html>
