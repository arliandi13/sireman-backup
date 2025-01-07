<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<body>
    <div class="container">
        <h1 class="my-4">Keranjang Pesanan</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjang as $id => $item)
                <tr>
                    <td>{{ $item['menu']->deskripsi }}</td>
                    <td>
                        <form action="{{ route('pesanan.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $id }}">
                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>Rp{{ number_format($item['menu']->harga * $item['jumlah'], 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('pesanan.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $id }}">
                            <input type="hidden" name="jumlah" value="0">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form id="pesananForm" action="{{ route('pesanan.simpan') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" class="form-control" name="nama_pelanggan" 
                       value="{{ session('customer') ? session('customer')->name : '' }}" 
                       {{ session('customer') ? 'readonly' : '' }} required>
                @if(session('customer'))
                    <input type="hidden" name="nama_pelanggan" value="{{ session('customer')->name }}">
                @endif
            </div>
        
            <div class="mb-3">
                <label for="deskripsi">Catatan Tambahan</label>
                <textarea class="form-control" name="catatan_tambahan" rows="3" placeholder="Catatan untuk pesanan..."></textarea>
            </div>
            
            <div class="mb-3">
                <label for="bangku">Bangku</label>
                <input type="number" class="form-control" id="bangku" name="bangku">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="bawaPulang" name="is_bawa_pulang" value="1">
                <label class="form-check-label" for="bawaPulang">Bawa Pulang</label>
            </div>
            
            <h3>Total Harga: Rp{{ number_format($totalHarga, 0, ',', '.') }}</h3>
            <button type="submit" class="btn btn-success">Simpan Pesanan</button>
            <a href="/" class="btn btn-secondary">Kembali ke Menu</a>
        </form>                
    </div>

    <script>
        document.getElementById('pesananForm').addEventListener('submit', function(event) {
            const bangku = document.getElementById('bangku').value.trim();
            const bawaPulang = document.getElementById('bawaPulang').checked;

            // Validasi hanya salah satu yang dipilih
            if (bangku && bawaPulang) {
                alert("Harap pilih salah satu antara No Bangku atau Bawa Pulang.");
                event.preventDefault(); // Batalkan pengiriman form
            }
        });
    </script>
</body>
</html>
