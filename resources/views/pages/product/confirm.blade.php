@extends('layouts.app')

@section('content')
@php
$order = session('order');
@endphp
<div class="d-flex flex-column gap-4 p-4">
    <div class="d-flex flex-column gap-1 text-center">
        <span>Tunggu sebentar ya</span>
        <span>Pesanan kamu sedang diproses</span>
    </div>
    <div class="d-flex flex-column gap-4 py-4 px-3 rounded" style="background-color: #D9D9D9;">
        <div class="d-flex flex-column gap-1">
            <span class="fw-bold fs-6 text-uppercase">nomor meja {{ $order['no_meja'] ?? '-' }}</span>
            <span class="fw-light" style="font-size: 16px;">{{ $order['name'] ?? '-' }}</span>
        </div>
        <div class="d-flex flex-column gap-2 py-4" style="border-bottom: 2px solid #000;">
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <span class="fs-6 fw-bold">Internet</span>
                    <span style="font-size: 12px;">Catatan: Jangan Pedas</span>
                </div>
                <span class="fw-bold">Rp. 10.000</span>
            </div>
            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <span class="fs-6 fw-bold">Internet</span>
                    <span style="font-size: 12px;">Catatan: Jangan Pedas</span>
                </div>
                <span class="fw-bold">Rp. 10.000</span>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <span class="fw-bold">Total</span>
            <span class="fw-bold">Rp. 20.000</span>
        </div>
        <div class="py-2 w-100">
            <button onclick="window.location.href = '{{ route('products.wait') }}'" class="w-100 btn py-2 text-white" style="background-color: #989898; border-radius: 50px;">Konfirmasi Pesanan</button>
        </div>
    </div>
</div>
@endsection