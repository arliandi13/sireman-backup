<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .table {
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table td {
            background-color: #fff;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .table-hover tbody tr:hover {
            background-color: #e6e6e6;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        h2 {
            font-size: 2.5rem;
            color: #333;
            font-weight: bold;
        }

        .navbar {
            background-color: #ff9800; /* Navbar tetap berwarna oren */
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar .brand img {
            height: 40px;
        }

        .navbar .navbar-text {
            color: white;
        }

        .container1 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Header Navbar -->
    <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('images/LogoRm.png') }}" alt="Logo">
            <span class="fw-bold">GOGO!</span>
        </div>
        <div class="navbar-text me-3">
            <span>Hello, {{ session('user')->name }}</span>
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-5 shadow-lg">
        <h2 class="text-center mb-4">Daftar Penjualan</h2>

        @if($pembayaran->count() == 0)
        <p class="text-center">Tidak ada data pembayaran yang ditemukan.</p>
        @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Detail Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembayaran as $pay)
                    @php
                    // Dekode JSON untuk mendapatkan detail pesanan sebagai array
                    $detailPesanan = json_decode($pay->detail_pesanan, true);
                    @endphp

                    <tr>
                        <td>{{ $pay->kode_pesanan }}</td>
                        <td>
                            @if($detailPesanan && is_array($detailPesanan))
                            @foreach ($detailPesanan as $item)
                            @if(isset($item['deskripsi'], $item['jumlah']))
                            <div><strong>{{ $item['deskripsi'] }}</strong> - {{ $item['jumlah'] }} pcs</div>
                            @else
                            <div>Data pesanan tidak lengkap</div>
                            @endif
                            @endforeach
                            @else
                            <div>Detail pesanan tidak tersedia</div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="text-end mt-3">
            <a href="{{ url('/dashboard-pemilik') }}" class="btn-back">Kembali</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
