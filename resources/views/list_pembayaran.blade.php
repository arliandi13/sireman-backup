<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Kode Pembayaran</th>
                <th>Kode Pesanan</th>
                <th>Jumlah Dibayar</th>
                <th>Metode Pembayaran</th>
                <th>Kembalian</th>
                <th>Waktu Pembayaran</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran as $pay)
            <tr>
                <td>{{ $pay->kode_pembayaran }}</td>
                <td>{{ $pay->kode_pesanan }}</td>
                <td>{{ number_format($pay->jumlah, 2) }}</td>
                <td>{{ $pay->metode }}</td>
                <td>{{ number_format($pay->kembalian, 2) }}</td>
                <td>{{ $pay->created_at }}</td>
                <td>
                    <form action="{{ route('print-pembayaran', $pay->id) }}" method="GET">
                        <button type="submit">Print</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</body>