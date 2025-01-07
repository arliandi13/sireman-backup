<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ $pembayaran->kode_pembayaran }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            width: 80mm; /* Ukuran kertas struk */
            height: 100%;
            box-sizing: border-box;
            background-color: #f8f8f8;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            margin: 10px 0;
        }
        .table-wrapper {
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
        }
        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px 8px;
            font-size: 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            width: 35%;
            font-weight: normal;
        }
        td {
            font-weight: bold;
            color: #000;
        }
        .label {
            font-weight: normal;
            text-transform: uppercase;
            color: #555;
        }
        .line {
            border-bottom: 1px solid #000;
            margin-top: 5px;
        }
        .total {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        .total span {
            display: inline-block;
            width: 50%;
            text-align: left;
        }
        .detail {
            margin-top: 10px;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Pembayaran #{{ $pembayaran->kode_pembayaran }}</h1>
    <div class="table-wrapper">
        <table>
            <tr>
                <th class="label">Kode Pembayaran</th>
                <td>{{ $pembayaran->kode_pembayaran }}</td>
            </tr>
            <tr>
                <th class="label">Kode Pesanan</th>
                <td>{{ $pembayaran->kode_pesanan }}</td>
            </tr>
            <tr>
                <th class="label">Nama Pelanggan</th>
                <td>{{ $pesanan->nama_pelanggan }}</td>
            </tr>
            <tr>
                <th class="label">No Meja</th>
                <td>{{ !empty($pesanan->bangku) ? $pesanan->bangku : 'Tidak Diketahui' }}</td>
            </tr>
            <tr>
                <th class="label">Bawa Pulang</th>
                <td>{{ $pesanan->is_bawa_pulang ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <th class="label">Catatan Tambahan</th>
                <td>{{ $pesanan->catatan_tambahan }}</td>
            </tr>
            <tr>
                <th class="label">Jumlah Pembayaran</th>
                <td>Rp {{ number_format($pembayaran->jumlah, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="label">Kembalian</th>
                <td>Rp {{ number_format($pembayaran->kembalian, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="label">Metode Pembayaran</th>
                <td>{{ $pembayaran->metode }}</td>
            </tr>
            <tr>
                <th class="label">Tanggal Pembayaran</th>
                <td>{{ $pembayaran->created_at }}</td>
            </tr>
        </table>

        <div class="line"></div>
        
        <h2>Detail Pesanan:</h2>
        @if ($pesanan)
        @php
            // Mengambil detail pesanan dari JSON
            $items = is_string($pesanan->detail_pesanan) ? json_decode($pesanan->detail_pesanan, true) : [];
        @endphp
        <div class="detail">
            @foreach($items as $item)
                <p>{{ $item['deskripsi'] ?? 'Unknown' }} - {{ $item['jumlah'] ?? 0 }} x Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</p>
            @endforeach
        </div>
        @else
        <p>Pesanan tidak ditemukan.</p>
        @endif

        <div class="line"></div>

        <div class="total">
            <span>Total Pembayaran</span>
            <span>Rp {{ number_format($pembayaran->jumlah, 2, ',', '.') }}</span>
        </div>

        <div class="footer">
            Terima kasih atas kunjungan Anda. Selamat menikmati!
        </div>
    </div>
</body>
</html>
