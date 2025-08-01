@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <span class="font-bold">Produk</span>
            </div>
            <div class="card-body ">
                <button>
                    <a class="btn btn-sm btn-primary" href="{{ route('inventory.create') }}">Tambah Produk</a>
                </button>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Topping</th>
                            <th scope="col">Ready?</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->imageUrl)
                                <img src="{{ asset('storage/' . $product->imageUrl) }}" alt="Product Image" width="100">
                                @else
                                No Image
                                @endif
                            </td>
                            <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->category }}</td>
                            <td><span class="badge bg-primary text-white">{{ $product->toppings()->pluck('name')->implode(', ') }}</span></td>
                            <td>
                                @if ($product->is_available)
                                <span class="text-success">Ready</span>
                                @else
                                <span class="text-danger">Not Ready</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('inventory.edit', $product->id) }}" class="btn btn-sm btn-warning text-white d-inline-block">
                                    Edit
                                </a>
                                <div class="d-inline-block">
                                    <form action="{{ route('inventory.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <!--  -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>