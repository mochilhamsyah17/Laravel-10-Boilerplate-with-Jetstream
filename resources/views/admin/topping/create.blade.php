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
                <span class="font-bold">Topping</span>
            </div>
            <div class="card-body">
                <form action="{{ route('topping.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="d-flex flex-column gap-3">

                        <div class="form-group">
                            <label for="name">Nama Topping</label>
                            <input type="text" name="name" id="name" placeholder="masukkan nama topping..." class="form-control ">
                        </div>

                        <div class="form-group">
                            <label for="price">Harga Topping</label>
                            <input type="number" name="price" id="price" placeholder="masukkan harga topping..." class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="is_available">Status Topping</label>
                            <select name="is_available" id="is_available" class="form-control">
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Tambah Topping</button>
                </form>
            </div>
        </div>
    </div>
</div>