@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <span class="font-bold">Toppings</span>
            </div>
            <div class="card-body ">

                <button>
                    <a class="btn btn-sm btn-primary" href="{{ route('topping.create') }}">Tambah Topping</a>
                </button>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Topping</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($toppings as $topping)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $topping->name }}</td>
                            <td>Rp. {{ number_format($topping->price, 0, ',', '.') }}</td>
                            <td>
                                <button>
                                    <a>Edit</a>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>