@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
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

                <span class="font-bold">Users</span>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <form class="d-flex flex-column" action="{{  route('user.store')  }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="d-flex flex-column">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="py-1 rounded border-none px-2" placeholder="masukkan nama..." style="font-size: 12px;">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="py-1 rounded border-none px-2" placeholder="masukkan email..." style="font-size: 12px;">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="py-1 rounded border-none px-2" placeholder="masukkan password..." style="font-size: 12px;">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="py-1 rounded border-none px-2" style="font-size: 12px;">
                            <option value="1">Admin</option>
                            <option value="2">Kasir</option>
                        </select>
                    </div>

                    <div class="d-flex flex-column mt-4">
                        <button class="btn py-2 text-white" style="background-color: #535353; border-radius: 50px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>