<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIREMAN</title>
    <!-- Import Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">
            <img src="https://via.placeholder.com/50" alt="Logo" class="d-inline-block align-text-top">
            SIREMAN
        </a>
        <div>
            <span class="me-3">Hello, {{ session('user')->name }}</span>
            <a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-4">
    <div class="mb-3">
        <h4>Total Pesanan: {{ $totalPesanan }}</h4>
        <ul class="list-unstyled d-flex">
            @foreach ($statusCounts as $status => $count)
                <li class="me-4">
                    <strong>{{ $status }}:</strong> {{ $count }}
                </li>
            @endforeach
        </ul>
    </div>

    <form method="GET" action="{{ route('dashboard-koki') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari sesuatu..." value="{{ $searchQuery }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach (array_keys($statusCounts) as $status)
                        <option value="{{ $status }}" {{ $statusFilter === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Pesanan</th>
                <th>Nama Pelanggan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $item)
                <tr>
                    <td>{{ $item->kode_pesanan }}</td>
                    <td>{{ $item->nama_pelanggan }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        <form method="POST" action="{{ route('update-status', $item->kode_pesanan) }}">
                            @csrf
                            <label for="status">Update Status:</label>
                            <select name="status" id="status" class="form-select" {{ $item->is_paid === 0 && in_array($item->status, ['Selesai', 'Dibatalkan']) ? 'disabled' : '' }}>
                                <option value="Dalam Antrian" {{ $item->status === 'Dalam Antrian' ? 'selected' : '' }}>Dalam Antrian</option>
                                <option value="Sedang Disiapkan" {{ $item->status === 'Sedang Disiapkan' ? 'selected' : '' }}>Sedang Disiapkan</option>
                                <option value="Siap Diantar" {{ $item->status === 'Siap Diantar' ? 'selected' : '' }}>Siap Diantar</option>
                                <option value="Selesai" {{ $item->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ $item->status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Ubah Status</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
