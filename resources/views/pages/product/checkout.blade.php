@extends('layouts.app')

@section('content')
<section class="position-relative d-flex flex-column gap-4 pb-4">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="position-relative">
        <!-- 🔙 Tombol Back -->
        <div class="position-absolute top-0 start-0 m-3 p-2 d-flex align-items-center justify-content-center"
            onclick="window.history.back();"
            style="background-color: #535353; border-radius: 50%; cursor: pointer; width: 36px; height: 36px;">
            <img src="{{ asset('assets/images/icon-back.webp') }}" alt="Back" style="width: 16px;">
        </div>
        <span class="fs-4 fw-bold text-center d-flex flex-column mt-3">CHECKOUT</span>
    </div>

    @php
    $subTotal = 0;
    @endphp

    <!-- ✅ FORM -->
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="d-flex flex-column gap-4 px-3">
            @foreach($orderItems as $key => $orderItem)
            @php
            $toppings = $orderItem['toppings'] ?? [];
            // Pastikan toppings adalah array
            if (is_string($toppings)) {
            $toppings = json_decode($toppings, true) ?: [];
            }

            $toppingTotal = 0;
            foreach ($toppings as $topping) {
            $toppingTotal += is_array($topping) ? ($topping['price'] ?? 0) : (is_object($topping) ? $topping->price : 0);
            }

            $productTotal = ($orderItem['price'] * $orderItem['quantity']) + ($toppingTotal * $orderItem['quantity']);
            $subTotal += $productTotal;
            @endphp

            <!-- ✅ CARD ITEM -->
            <div class="d-flex flex-row rounded overflow-hidden p-3 gap-3 text-white order-card position-relative"
                style="min-height: 200px; background-color: #535353;"
                data-price="{{ $orderItem['price'] }}"
                data-topping="{{ $toppingTotal }}"
                data-key="{{ $key }}">

                <!-- ✅ Tombol Delete di pojok kanan atas -->
                <i class="fa-solid fa-circle-xmark position-absolute top-0 end-0 m-2 text-white cursor-pointer border-0 rounded-circle delete-item" data-key="{{ $key }}"></i>
                
                <div class="d-flex flex-column gap-1" style="width: 35%;">
                    <img src="{{ isset($orderItem['imageUrl']) ? Storage::url($orderItem['imageUrl']) : asset('assets/images/bibimbap.webp') }}" alt="img" class="rounded" style="height: 100%; object-fit: cover;">
                    
                    <!-- ✅ Quantity Box -->
                    <div class="d-flex flex-row gap-3 py-1 px-3 fw-bold text-black rounded justify-content-between align-items-center"
                        style="background-color: #D9D9D9; height: fit-content;">
                    
                        <button type="button"
                            class="qty-btn border-0 bg-transparent fs-5"
                            data-key="{{ $key }}" data-change="-1">−</button>

                        <span id="qty-display-{{ $key }}">{{ $orderItem['quantity'] }}</span>

                        <button type="button"
                            class="qty-btn border-0 bg-transparent fs-5"
                            data-key="{{ $key }}" data-change="1">+</button>
                    </div>
                </div>
                    
                <!-- ✅ Info Produk -->
                <div class="d-flex flex-column justify-content-between gap-2 flex-grow-1">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="d-flex flex-column gap-1">
                            <span class="fs-6 fw-bold">{{ $orderItem['name'] }}</span>
                            <span class="fw-bold">Rp. {{ number_format($orderItem['price'], 0, ',', '.') }}</span>

                            <!-- ✅ Toppings -->
                            @if(!empty($toppings))
                            <small class="mt-1">Topping:</small>
                            <ul class="m-0 ps-3">
                                @foreach($toppings as $topping)
                                @php
                                $toppingName = is_array($topping) ? ($topping['name'] ?? '') : (is_object($topping) ? $topping->name : '');
                                $toppingPrice = is_array($topping) ? ($topping['price'] ?? 0) : (is_object($topping) ? $topping->price : 0);
                                @endphp
                                <li>{{ $toppingName }} (+Rp{{ number_format($toppingPrice, 0, ',', '.') }})</li>
                                @endforeach
                            </ul>
                            @endif

                            <!-- ✅ Total Per Item -->
                            <small class="mt-2 item-total">
                                Total Item: <b id="item-total-{{ $key }}">Rp{{ number_format($productTotal, 0, ',', '.') }}</b>
                            </small>
                        </div>
                    </div>

                    <!-- ✅ Catatan -->
                    <div class="d-flex flex-column gap-2">
                        <span class="fw-light fs-6">Catatan</span>
                        <input type="text" name="order_items[{{ $key }}][note]" class="py-1 rounded border-none px-2"
                            placeholder="Catatan untuk produk ini" style="font-size: 12px;">
                    </div>
                </div>
            </div>


            <!-- ✅ Hidden Inputs (agar data terkirim) -->
            <input type="hidden" name="order_items[{{ $key }}][product_id]" value="{{ $orderItem['product_id'] }}">
            <input type="hidden" name="order_items[{{ $key }}][price]" value="{{ $orderItem['price'] }}">
            <input type="hidden" name="order_items[{{ $key }}][quantity]" id="qty-input-{{ $key }}" value="{{ $orderItem['quantity'] }}">

            <!-- ✅ Improved toppings handling -->
            @if(!empty($toppings))
            @foreach($toppings as $toppingIndex => $topping)
            <input type="hidden" name="order_items[{{ $key }}][toppings][{{ $toppingIndex }}][id]" value="{{ is_array($topping) ? ($topping['id'] ?? '') : (is_object($topping) ? $topping->id : '') }}">
            <input type="hidden" name="order_items[{{ $key }}][toppings][{{ $toppingIndex }}][name]" value="{{ is_array($topping) ? ($topping['name'] ?? '') : (is_object($topping) ? $topping->name : '') }}">
            <input type="hidden" name="order_items[{{ $key }}][toppings][{{ $toppingIndex }}][price]" value="{{ is_array($topping) ? ($topping['price'] ?? 0) : (is_object($topping) ? $topping->price : 0) }}">
            @endforeach
            @endif
            @endforeach
        </div>

        <!-- ✅ Bagian Total -->
        <div class="d-flex flex-column gap-2 px-3 pt-4">
            <div class="d-flex flex-row justify-content-between">
                <span class="fs-6 fw-bold">Sub Total</span>
                <span class="fs-6 fw-bold" id="subtotal">Rp. {{ number_format($subTotal, 0, ',', '.') }}</span>
            </div>

            <div style="border-top: 2px dashed #000;"></div>

            <div class="d-flex flex-row justify-content-between">
                <span class="fs-6 fw-bold">Total</span>
                <span class="fs-6 fw-bold" id="total">Rp. {{ number_format($subTotal, 0, ',', '.') }}</span>
            </div>

            <!-- ✅ Tombol Checkout -->
            <div class="pt-4 w-100">
                <button type="submit" class="w-100 btn py-2 text-white"
                    style="background-color: #535353; border-radius: 50px;">
                    Checkout
                </button>
            </div>
        </div>
    </form>
</section>
@endsection

@section('script')
<script>
    function formatRupiah(angka) {
        return 'Rp' + angka.toLocaleString('id-ID');
    }

    function updateTotal() {
        let subtotal = 0;

        document.querySelectorAll('.order-card').forEach(card => {
            let price = parseInt(card.dataset.price);
            let topping = parseInt(card.dataset.topping);
            let key = card.dataset.key;
            let qty = parseInt(document.getElementById('qty-input-' + key).value);
            let itemTotal = (price + topping) * qty;

            document.getElementById('item-total-' + key).textContent = formatRupiah(itemTotal);
            subtotal += itemTotal;
        });

        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('total').textContent = formatRupiah(subtotal);
    }

    // ✅ Event listener qty dengan AJAX
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let key = this.dataset.key;
            let change = parseInt(this.dataset.change);

            let qtyDisplay = document.getElementById('qty-display-' + key);
            let qtyInput = document.getElementById('qty-input-' + key);

            let newQty = Math.max(1, parseInt(qtyInput.value) + change);

            // ✅ Update DOM sementara (UX lebih responsif)
            qtyDisplay.textContent = newQty;
            qtyInput.value = newQty;

            // ✅ Kirim AJAX ke backend
            fetch('{{ route('order.updateQty') }}',{
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            key: key,
                            quantity: newQty
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateTotal(); // ✅ Re-hit total
                    } else {
                        alert('Gagal update qty!');
                    }
                })
                .catch(err => console.error(err));
        });
    });

    // ✅ Event listener tombol hapus
document.querySelectorAll('.delete-item').forEach(button => {
    button.addEventListener('click', function () {
        const key = this.dataset.key;

        // Hapus elemen item dari DOM
        const itemCard = document.querySelector(`.order-card[data-key="${key}"]`);
        const inputElements = document.querySelectorAll(`input[name^="order_items[${key}]"]`);

        if (itemCard) itemCard.remove();
        inputElements.forEach(input => input.remove());

        // Update total
        updateTotal();

        // (Opsional) Kirim ke backend untuk hapus dari session
        fetch('{{ route('order.removeItem') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ key: key })
        }).then(response => response.json())
          .then(data => {
              if (!data.success) {
                  alert('Gagal menghapus item dari sesi!');
              }
          }).catch(console.error);
    });
});

</script>
@endsection