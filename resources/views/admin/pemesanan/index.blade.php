@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="container-fluid">
        <div class="row gap-2 justify-content-center">
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Orderan Pending</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-hourglass-half"></i>
                    <span>{{ $dataPendingCount }}</span>
                </div>
            </div>
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Orderan Selesai</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span>{{ $dataCompletedCount }}</span>
                </div>
            </div>
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Total Transaksi</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <span>{{ number_format($totalPrice) }}</span>
                </div>
            </div>
        </div>

        <div class="py-3 px-2 fs-5 text-center border border-dark rounded-top" style="background-color: #D9D9D9;">
            <span class="font-bold">Transaksi</span>
        </div>

        <form action="{{ route('pemesanan.index') }}" action="GET" class="d-flex flex-row gap-2 align-items-center justify-content-between p-3 border border-dark" style="background-color: #D9D9D9; margin-bottom:0">
            @csrf
            <input type="text" name="search" class="form-control w-50" placeholder="Cari pesanan" value="{{ request('search') }}">
            <select name="sort_by" class="form-control w-25">
                <option value="id" {{ ($filters['sort_by'] ?? '') === 'id' ? 'selected' : '' }}>ID</option>
                <option value="name" {{ ($filters['sort_by'] ?? '') === 'name' ? 'selected' : '' }}>Nama</option>
                <option value="table_number" {{ ($filters['sort_by'] ?? '') === 'table_number' ? 'selected' : '' }}>Nomor Meja</option>
            </select>
            <select name="order" class="form-control w-25">
                <option value="asc" {{ ($filters['order'] ?? '') === 'asc' ? 'selected' : '' }}>Asc</option>
                <option value="desc" {{ ($filters['order'] ?? '') === 'desc' ? 'selected' : '' }}>Desc</option>
            </select>
            <button type="submit" class="btn bg-secondary text-white">Cari</button>
        </form>

        <table class="table table-bordered border-dark align-middle">
            <thead>
                <tr class="text-center">
                    <th class="border-end">ID</th>
                    <th class="border-start border-end">Nama</th>
                    <th class="border-start border-end">No Meja</th>
                    <th class="border-start border-end">Pesanan</th>
                    <th class="border-start border-end">Total</th>
                    <th class="border-start border-end">Status</th>
                    <th class="border-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr class="text-center">
                    <th scope="row">#{{ $d->id }}</th>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->table_number }}</td>
                    <td class="text-start">
                        <ul class="d-flex flex-column gap-2">
                            @foreach($d->orderItems as $item)
                            <li>
                                - {{ $item->product->name ?? '-' }} ({{ $item->quantity }})
                                <ul style="font-size: 12px;">
                                    <li>Topping:
                                        {{ $item->toppings->pluck('name')->implode(', ') ?: '-' }}
                                    </li>
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp.{{ number_format($d->total_price) }}</td>
                    <td>
                        <div data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $d->id }}"
                            class="badge 
                        @if($d->status == 'pending') bg-warning 
                        @elseif($d->status == 'completed') bg-info 
                        @else bg-danger @endif">
                            {{ $d->status }}
                        </div>
                    </td>
                    <td>
                        <button>
                            <a href="{{ route('pemesanan.detail', $d->id) }}" class="badge bg-secondary text-white text-decoration-none">Lihat detail</a>
                        </button>
                    </td>
                </tr>

                <!-- Modal Status -->
                <div class="modal fade mt-10" id="updateStatusModal{{ $d->id }}" tabindex="-1"
                    aria-labelledby="updateStatusModalLabel{{ $d->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('pemesanan.updateStatus', $d->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel{{ $d->id }}">
                                        Ubah Status - #{{ $d->id }} - {{ $d->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="status-{{ $d->id }}">Pilih Status</label>
                                        <select name="status" id="status-{{ $d->id }}" class="form-control" required>
                                            <option value="pending" {{ $d->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ $d->status == 'completed' ? 'selected' : '' }}>Terima</option>
                                            <option value="cancelled" {{ $d->status == 'cancelled' ? 'selected' : '' }}>Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>


    </div>
</div>