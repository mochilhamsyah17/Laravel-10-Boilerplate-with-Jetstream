@extends('layouts.app')

@section('content')

<section class="container flex d-flex flex-column gap-4 py-4 px-2">
    <span class="d-flex text-center" style="letter-spacing: 4px;">JANGAN LUPA MAKAN, SEMOGA HARI MU HAHA HIHI</span>

    <div class="p-3 rounded" style="border: 2px solid ; border-color: #000;">
        <span class="d-flex text-start fw-bold text-capitalize">Pilih menu</span>
    </div>

    <div class="scroll-x-hidden rounded" style="border: 2px solid #000;">
        <div class="p-3 d-flex flex-row justify-content-between" style="min-width: max-content;">
            <div class="d-flex flex-column text-center align-items-center justify-content-center me-3">
                <img src="{{ asset('assets/images/bibimbap.webp') }}" alt="food" style="width: 60px;">
                <span class="fs-6">Makanan</span>
            </div>
            <div class="d-flex flex-column text-center align-items-center justify-content-center me-3">
                <img src="{{ asset('assets/images/drink.webp') }}" alt="drink" style="width: 60px;">
                <span class="fs-6">Minuman</span>
            </div>
            <div class="d-flex flex-column text-center align-items-center justify-content-center me-3">
                <img src="{{ asset('assets/images/coffee-cup.webp') }}" alt="coffee" style="width: 60px;">
                <span class="fs-6">Kopi</span>
            </div>
            <div class="d-flex flex-column text-center align-items-center justify-content-center">
                <img src="{{ asset('assets/images/snack.webp') }}" alt="snack" style="width: 60px;">
                <span class="fs-6">Snack</span>
            </div>
        </div>
    </div>


    <div class="d-flex flex-row rounded overflow-hidden" style="height: 200px; border: 2px solid ; border-color: #000;">
        <img src="{{ asset('assets/images/internet.webp') }}" alt="img" style="width: 35%; height: 100%; object-fit: cover; border: 2px solid #000; border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
        <div class=" p-3 d-flex flex-column justify-content-between gap-1 flex-grow-1">
            <div class="d-flex flex-column gap-1">
                <span class="fs-6 fw-bold">Internet</span>
                <span class="fw-lighter" style="font-size: 10px;">
                    Mie yang dipadukan kornet sapi serta telur yang disajikan istimewa kepada anda
                </span>
                <span class="fw-bold">Rp. 10.000</span>
            </div>
            <button onclick="window.location.href = '{{ route('products.index') }}'" class="py-2 text-white rounded btn" style="background-color: #989898; font-size: 10px;">Tambah</button>
        </div>
    </div>

    <div class="d-flex flex-row rounded overflow-hidden" style="height: 200px; border: 2px solid ; border-color: #000;">
        <img src="{{ asset('assets/images/internet.webp') }}" alt="img" style="width: 35%; height: 100%; object-fit: cover; border: 2px solid #000; border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
        <div class=" p-3 d-flex flex-column justify-content-between gap-1 flex-grow-1">
            <div class="d-flex flex-column gap-1">
                <span class="fs-6 fw-bold">Internet</span>
                <span class="fw-lighter" style="font-size: 10px;">
                    Mie yang dipadukan kornet sapi serta telur yang disajikan istimewa kepada anda
                </span>
                <span class="fw-bold">Rp. 10.000</span>
            </div>
            <button onclick="window.location.href = '{{ route('products.index') }}'" class="py-2 text-white rounded btn" style="background-color: #989898; font-size: 10px;">Tambah</button>
        </div>
    </div>


</section>

@endsection