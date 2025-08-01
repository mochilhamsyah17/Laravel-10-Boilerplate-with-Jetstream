@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="card-header">
                <span class="font-bold">Produk</span>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="d-flex flex-column gap-3">

                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" name="name" id="name" placeholder="masukkan nama produk..." class="form-control" value="{{ $product->name }}">
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Produk</label>
                            @if($product->imageUrl)
                            <img src="{{ asset('storage/' . $product->imageUrl) }}" alt="Gambar Produk" width="120" class="mb-2">
                            @endif
                            <input type="file" name="imageUrl" id="imageUrl" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            <input type="number" name="price" id="price" placeholder="masukkan harga produk..." class="form-control" value="{{ $product->price }}">
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <input type="text" name="description" id="description" placeholder="masukkan deskripsi produk..." class="form-control" value="{{ $product->description }}">
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori Produk</label>
                            <select name="category" id="category" class="form-control">
                                <option value="makanan" {{ $product->category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="softdrink" {{ $product->category == 'softdrink' ? 'selected' : '' }}>Softdrink</option>
                                <option value="snack" {{ $product->category == 'snack' ? 'selected' : '' }}>Snack</option>
                                <option value="kopi" {{ $product->category == 'kopi' ? 'selected' : '' }}>Kopi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="is_available">Status Produk</label>
                            <select name="is_available" id="is_available" class="form-control">
                                <option value="1" {{ $product->is_available == 1 ? 'selected' : '' }}>Tersedia</option>
                                <option value="0" {{ $product->is_available == 0 ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="topping_ids">Topping Produk</label>
                            <select name="topping_ids[]" id="topping_ids" class="form-control" multiple>
                                @foreach ($toppings as $topping)
                                <option value="{{ $topping->id }}" {{ in_array($topping->id, $product->toppings->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $topping->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Update Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>