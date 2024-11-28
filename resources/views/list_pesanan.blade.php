<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">List Pesanan</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Detail Pesanan</th>
                    <th>No Meja</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan as $pesan)
                <tr>
                    <td>{{ $pesan->kode_pesanan }}</td>
                    <td>{{ $pesan->nama_pelanggan }}</td>
                    <<td>
                        <ul>
                            @php
                                $items = is_string($pesan->detail_pesanan) 
                                    ? json_decode($pesan->detail_pesanan, true) 
                                    : $pesan->detail_pesanan;
                            @endphp
                            @foreach($items as $item)
                            <li>
                                {{ $item['deskripsi'] ?? 'Unknown' }} -
                                {{ $item['jumlah'] ?? 0 }} x Rp{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @if($pesan->is_bawa_pulang)
                            Bawa Pulang
                        @elseif(!empty($pesan->bangku))
                            Nomor Meja: {{ $pesan->bangku }}
                        @else
                            Tidak Diketahui
                        @endif
                    </td>
                    <td>{{ $pesan->status }}</td>
                    <td>Rp{{ number_format($pesan->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/" class="btn btn-secondary mt-3">Kembali ke Menu</a>
    </div>
</body>
</html>
