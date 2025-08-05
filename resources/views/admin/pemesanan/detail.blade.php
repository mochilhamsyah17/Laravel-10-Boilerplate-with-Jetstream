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
    <div class="container-fluid d-flex flex-column gap-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <span class="fs-5 fw-semibold">Order Number #{{ $order->id }}</span>
            <a href="{{ route('pemesanan.index') }}" class="d-flex flex-row justify-content-between align-items-center gap-1 btn btn-sm btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
        <div class="row gap-2">

            <div class="col-md-7 table-responsive">
                <div class="bg-white border border-dark rounded-lg overflow-hidden">
                    <table class="table mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-start" colspan="4">Pesanan</th>
                                <th>QTY</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $orderItem)
                            <tr class="align-middle">
                                <td colspan="4">
                                    <div class="d-flex flex-row gap-2 align-items-center">
                                        <img src="{{ Storage::url($orderItem->product->imageUrl) }}" alt="img" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        <span class="text-start">{{ $orderItem->product->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span>{{ $orderItem->quantity }}</span>
                                </td>
                                <td>
                                    <span>Rp. {{ number_format($orderItem->product->price, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span>Rp. {{ number_format($orderItem->price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-white border border-dark rounded-lg">
                    <div class="d-flex flex-column gap-2 p-2">
                        <span class="fs-6 fw-bold pb-3">Detail Pesanan</span>
                        <div class="d-flex flex-row justify-content-between">
                            <span>Pesanan dibuat</span>
                            <span>{{ date_format($order->created_at, 'd F Y') }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <span>Waktu</span>
                            <span>{{ date_format($order->created_at, 'H:i') }}</span>
                        </div>
                        <div class="fw-semibold mt-4 d-flex flex-row justify-content-between">
                            <span>Total</span>
                            <span>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 table-responsive">
                <div class="d-flex flex-column bg-white border border-dark rounded-lg overflow-hidden p-2 gap-2">
                    <span>Detail Kostumer</span>
                    <div class="d-flex flex-row justify-content-between">
                        <span>Nama Kostumer</span>
                        <span class="text-capitalize">{{ $order->name }}</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <span>Nomor Meja</span>
                        <span>{{ $order->table_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>