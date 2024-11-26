<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIREMAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/50" alt="Logo" class="d-inline-block align-text-top">
                SIREMAN
            </a>
            <div>
                @if(session('user'))
                    <span class="me-3">Hello, {{ session('user')->name }}</span>
                    <a href="/profile" class="btn btn-outline-primary btn-sm">Profile</a>
                    <a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
                @else
                    <a href="/login" class="btn btn-outline-primary btn-sm">Login</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container">
        <h1 class="my-4">Menu</h1>

        <!-- Keranjang Button -->
        @if(session('user'))
        <a href="{{ route('pesanan.keranjang') }}" class="btn btn-primary mb-3">
            Keranjang ({{ count($keranjang ?? []) }})
        </a>
        <a href="{{ route('pesanan.list')}}" class="btn btn-secondary mb-3">List Pesanan</a>
        @else
        @endif


        <!-- Buttons for Category Filter -->
        <div class="text-center mb-3">
            <button class="btn btn-primary" id="btn-makanan">Makanan</button>
            <button class="btn btn-secondary" id="btn-minuman">Minuman</button>
        </div>

        <!-- Menu List -->
        <div class="row" id="menu-list">
            @foreach($menus as $menu)
                <div class="col-md-4 mb-3 menu-item {{ $menu->kategori }}">
                    <div class="card">
                        <img src="{{ $menu->gambar_menu }}" class="card-img-top" alt="{{ $menu->deskripsi }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->deskripsi }}</h5>
                            <p class="card-text">Harga: Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                            <p class="card-text">Kategori: {{ ucfirst($menu->kategori) }}</p>
                            @if(session('user') && session('user')->role === 'waiters')
                                <form action="{{ route('pesanan.tambah') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <button type="submit" class="btn btn-success btn-sm">Tambah Pesanan</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.menu-item').hide(); // Sembunyikan semua menu awalnya

            $('#btn-makanan').click(function () {
                $('.menu-item').hide();
                $('.makanan').fadeIn();
            });

            $('#btn-minuman').click(function () {
                $('.menu-item').hide();
                $('.minuman').fadeIn();
            });

            // Tampilkan semua menu secara default
            $('.menu-item').show();
        });
    </script>
</body>
</html>
