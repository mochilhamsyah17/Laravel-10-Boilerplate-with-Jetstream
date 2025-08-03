@extends('layouts.app')

@section('content')

<div class="d-flex flex-column gap-4 p-4">
    <div class="d-flex flex-column gap-1 text-center">
        <span>Kitchen Sudah Menerima Pesananmu</span>
        <span>Status Pesanan: 
            <span class="text-capitalize badge 
                @if($orderData->status == 'pending') bg-warning
                @elseif($orderData->status == 'processing') bg-info
                @elseif($orderData->status == 'ready') bg-primary
                @elseif($orderData->status == 'completed') bg-success
                @else bg-secondary
                @endif">
                {{ $orderData->status }}
            </span>
        </span>
    </div>
    <div class="d-flex flex-column gap-4 py-4 px-3 rounded" style="background-color: #D9D9D9;">
        <div class="d-flex flex-column gap-1">
            <span class="fw-bold fs-6 text-uppercase">nomor meja {{ $orderData->table_number ?? '-' }}</span>
            <span class="fw-light" style="font-size: 16px;">{{ $orderData->name ?? '-' }}</span>
        </div>
        <div class="d-flex flex-column gap-2 py-4" style="border-bottom: 2px solid #000;">

            @php $totalCalculated = 0; @endphp

            @foreach($orderItems as $orderItem)
                @php
                    // Hitung total harga toppings untuk item ini dari pivot table
                    $toppingsPrice = 0;
                    if($orderItem->toppings && $orderItem->toppings->count() > 0) {
                        foreach($orderItem->toppings as $topping) {
                            $toppingsPrice += $topping->pivot->price;
                        }
                    }
                    
                    // Total untuk item ini (sudah include toppings dari database)
                    $itemTotalPrice = $orderItem->price;
                    $totalCalculated += $itemTotalPrice;
                @endphp

                <div class="d-flex flex-row justify-content-between">
                    <div class="d-flex flex-column gap-1">
                        <span class="fs-6 fw-bold">{{ $orderItem->product->name }}</span>
                        <span style="font-size: 12px;">Qty: {{ $orderItem->quantity }}</span>
                        
                        @if($orderItem->toppings && $orderItem->toppings->count() > 0)
                            <span style="font-size: 12px;">
                                Topping: 
                                @foreach($orderItem->toppings as $topping)
                                    {{ $topping->name }}@if(!$loop->last), @endif
                                @endforeach
                            </span>
                        @endif
                        
                        @if($orderItem->notes)
                            <span style="font-size: 12px;">Catatan: {{ $orderItem->notes }}</span>
                        @endif

                        {{-- Detail breakdown harga --}}
                        <div style="font-size: 10px; color: #666;">
                            <div>Harga produk: Rp. {{ number_format($orderItem->product->price, 0, ',', '.') }} x {{ $orderItem->quantity }}</div>
                            @if($toppingsPrice > 0)
                                <div>Harga topping: Rp. {{ number_format($toppingsPrice, 0, ',', '.') }} x {{ $orderItem->quantity }}</div>
                            @endif
                        </div>
                    </div>
                    <span class="fw-bold">Rp. {{ number_format($itemTotalPrice, 0, ',', '.') }}</span>
                </div>
            @endforeach

        </div>
        
        <div class="d-flex flex-row justify-content-between">
            <span class="fw-bold">Total</span>
            <span class="fw-bold">Rp. {{ number_format($orderData->total_price, 0, ',', '.') }}</span>
        </div>

        {{-- Tombol refresh status atau kembali ke menu --}}
        <div class="py-2 w-100 d-flex gap-2">
            <button onclick="window.location.reload()" class="flex-fill btn py-2 text-white" style="background-color: #6c757d; border-radius: 50px;">
                Refresh Status
            </button>
            @if($orderData->status == 'completed')
                <button onclick="window.location.href = '{{ route('dashboard.index') }}'" class="flex-fill btn py-2 text-white" style="background-color: #28a745; border-radius: 50px;">
                    Pesan Lagi
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Auto refresh setiap 30 detik untuk update status --}}
<script>
    // Auto refresh setiap 30 detik untuk cek status pesanan
    setTimeout(function() {
        if(['pending', 'processing', 'ready'].includes('{{ $orderData->status }}')) {
            window.location.reload();
        }
    }, 30000);
</script>

@endsection