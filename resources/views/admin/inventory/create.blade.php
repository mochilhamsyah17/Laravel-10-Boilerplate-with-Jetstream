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
                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="d-flex flex-column gap-3">

                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" name="name" id="name" placeholder="masukkan nama produk..." value="{{ old('name') }}" class="form-control ">
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Produk</label>
                            <input type="file" name="imageUrl" id="imageUrl" value="{{ old('imageUrl') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            <input type="number" name="price" id="price" placeholder="masukkan harga produk..." value="{{ old('price') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <input type="text" name="description" id="description" placeholder="masukkan deskripsi produk..." value="{{ old('description') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="topping_ids">Topping Produk</label>
                            <select name="topping_ids[]" id="topping_ids" class="form-control" multiple>
                                @foreach ($toppings as $topping)
                                <option value="{{ $topping->id }}">{{ $topping->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori Produk</label>
                            <select name="category" id="category" class="form-control">
                                <option value="makanan">Makanan</option>
                                <option value="softdrink">Softdrink</option>
                                <option value="snack">Snack</option>
                                <option value="kopi">Kopi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="is_available">Status Produk</label>
                            <select name="is_available" id="is_available" class="form-control">
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Tambah Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>