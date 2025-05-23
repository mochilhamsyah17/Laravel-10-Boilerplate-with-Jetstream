@extends('layouts.app')

@section('content')

<section class="position-relative d-flex flex-column gap-4 pb-4">
    <div class="position-relative">
        <!-- Tombol Back -->
        <div
            class="position-absolute top-0 start-0 m-3 p-2 d-flex align-items-center justify-content-center"
            onclick="window.history.back();"
            style="background-color: #535353; border-radius: 50%; cursor: pointer; width: 36px; height: 36px;">
            <img src="{{ asset('assets/images/icon-back.webp') }}" alt="Back" style="width: 16px;">
        </div>
        <span class="fs-4 fw-bold text-center d-flex flex-column mt-3">
            CHECKOUT
        </span>
    </div>
    <div class="d-flex flex-column gap-4 px-3">
        <div class="d-flex flex-row rounded overflow-hidden p-3 gap-3 text-white" style="height: 200px; background-color: #535353;">
            <img src="{{ asset('assets/images/internet.webp') }}" alt="img" class="rounded" style="width: 35%; height: 100%; object-fit: cover;">
            <div class="d-flex flex-column justify-content-between gap-1 flex-grow-1">
                <div class="d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column gap-1">
                        <span class="fs-6 fw-bold">Internet</span>
                        <span class="fw-bold">Rp. 10.000</span>
                    </div>
                    <div class="d-flex flex-row gap-4 py-1 px-2 fw-bold text-black rounded justify-content-between align-items-center" style="background-color: #D9D9D9; height: fit-content;">
                        <span class="">-</span>
                        <span>1</span>
                        <span>+</span>
                    </div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <span class="fw-light fs-6">Catatan</span>
                    <input type="text" name="note" id="note" class="py-1 rounded border-none px-2" placeholder="Catatan" style="font-size: 12px;">
                </div>
            </div>
        </div>
        <div class="d-flex flex-row rounded overflow-hidden p-3 gap-3 text-white" style="height: 200px; background-color: #535353;">
            <img src="{{ asset('assets/images/internet.webp') }}" alt="img" class="rounded" style="width: 35%; height: 100%; object-fit: cover;">
            <div class="d-flex flex-column justify-content-between gap-1 flex-grow-1">
                <div class="d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column gap-1">
                        <span class="fs-6 fw-bold">Internet</span>
                        <span class="fw-bold">Rp. 10.000</span>
                    </div>
                    <div class="d-flex flex-row gap-4 py-1 px-2 fw-bold text-black rounded justify-content-between align-items-center" style="background-color: #D9D9D9; height: fit-content;">
                        <span class="">-</span>
                        <span>1</span>
                        <span>+</span>
                    </div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <span class="fw-light fs-6">Catatan</span>
                    <input type="text" name="note" id="note" class="py-1 rounded border-none px-2" placeholder="Catatan" style="font-size: 12px;">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column gap-2 px-3 pt-4">
        <div class="d-flex flex-row justify-content-between">
            <span class="fs-6 fw-bold">Sub Total</span>
            <span class="fs-6 fw-bold">Rp. 40.000</span>
        </div>
        <div style="border-top: 2px dashed #000;"></div>
        <div class="d-flex flex-row justify-content-between">
            <span class="fs-6 fw-bold">Total</span>
            <span class="fs-6 fw-bold">Rp. 40.000</span>
        </div>
        <div class="pt-4 w-100">
            <button class="w-100 btn py-2 text-white" style="background-color: #535353; border-radius: 50px;">Checkout</button>
        </div>
    </div>
</section>

@endsection