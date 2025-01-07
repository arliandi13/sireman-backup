<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h3 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .invoice-header p {
            font-size: 16px;
            color: #777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #28a745;
            color: white;
        }

        table td {
            color: #333;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .total-row {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .amount {
            font-size: 18px;
            color: #007bff;
        }

        .invoice-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 16px;
            color: #555;
        }

        .invoice-footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <h3>Laporan Keuangan</h3>
            <p>Ini adalah laporan keuangan yang mencakup semua pembayaran</p>
            <p><strong>Periode:</strong> {{ now()->format('d-m-Y') }}</p>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayaran as $pay)
                    <tr>
                        <td>{{ $pay->kode_pembayaran }}</td>
                        <td>{{ $pay->created_at->format('d-m-Y') }}</td>
                        <td>{{ 'Pembayaran untuk Pesanan ' . $pay->kode_pesanan }}</td>
                        <td class="text-right">Rp. {{ number_format($pay->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Row (Optional) -->
        <div class="total-row">
            <p class="text-right"><strong>Total Pemasukan:</strong> <span class="amount">Rp. {{ number_format($pembayaran->sum('jumlah'), 0, ',', '.') }}</span></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami.</p>
        </div>
    </div>

    <!-- Invoice Footer -->
    <div class="invoice-footer">
        <p>&copy; {{ now()->year }} - Laporan Keuangan GOGO! All rights reserved.</p>
    </div>
</body>
</html>
