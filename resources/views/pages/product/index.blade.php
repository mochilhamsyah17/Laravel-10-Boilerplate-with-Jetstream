@extends('layouts.app')

@section('content')

<section class="position-relative d-flex flex-column gap-4" style="padding-bottom: 128px;">
    <div class="position-relative">
        <!-- Tombol Back -->
        <div
            class="position-absolute top-0 start-0 m-3 p-2 d-flex align-items-center justify-content-center"
            onclick="window.history.back();"
            style="background-color: #535353; border-radius: 50%; cursor: pointer; width: 36px; height: 36px;">
            <img src="{{ asset('assets/images/icon-back.webp') }}" alt="Back" style="width: 16px;">
        </div>

        <!-- Gambar -->
        <img src="{{ asset('assets/images/internet.webp') }}" alt="Gambar"
            class="w-100" style="height: 256px; object-fit: cover;">
    </div>

    <div class="d-flex flex-column px-4 gap-2">
        <span class="fs-5 fw-bold">Internet</span>
        <span class="fs-6 fw-bold">(Indomie Kornet Telur)</span>
        <span class="fw-light" style="font-size: 12px;">Mie yang dipadukan kornet sapi serta telur yang disajikan istimewa kepada anda</span>
        <span class="fs-5 fw-bold">Rp.12.000</span>
        <div class="d-flex flex-row gap-2">
            <button class="btn py-2 px-4 text-white" style="background-color: #535353; border-radius: 50px;">Kuah</button>
            <button class="btn py-2 px-4 text-white" style="background-color: #535353; border-radius: 50px;">Goreng</button>
        </div>
        <div class="mt-2">Topping</div>
        <div class="rounded p-3" style="border: 2px solid #000;">
            <!-- Option 1 -->
            <div class="d-flex align-items-start justify-content-between mb-3 custom-radio">
                <div>
                    <div class="fw-bold">Keju</div>
                    <div>Rp 2000</div>
                </div>
                <input class="form-check-input" type="radio" name="topping" value="keju1" checked>
            </div>

            <!-- Option 2 -->
            <div class="d-flex align-items-start justify-content-between mb-3 custom-radio">
                <div>
                    <div class="fw-bold">Keju</div>
                    <div>Rp 2000</div>
                </div>
                <input class="form-check-input" type="radio" name="topping" value="keju2">
            </div>

            <!-- Option 3 -->
            <div class="d-flex align-items-start justify-content-between custom-radio">
                <div>
                    <div class="fw-bold">Keju</div>
                    <div>Rp 2000</div>
                </div>
                <input class="form-check-input" type="radio" name="topping" value="keju3">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center text-white position-fixed bottom-0 p-4 w-100"
        style="background-color: #D9D9D9; max-width: 512px;">

        <!-- Counter -->
        <div class="d-flex align-items-center bg-dark px-3 py-1 rounded-pill gap-3" style="font-size: 12px;">
            <button class="btn btn-light rounded-circle">-</button>
            <span class="px-2">1</span>
            <button class="btn btn-light rounded-circle">+</button>
        </div>

        <!-- Button Tambah -->
        <button onclick="window.location.href = '{{ route('products.checkout') }}'" class="btn text-white px-2 py-3 rounded-pill" style="background-color: #2b2b2b; font-size: 12px;">
            Tambah - Rp 14.000
        </button>
    </div>

</section>

@endsection