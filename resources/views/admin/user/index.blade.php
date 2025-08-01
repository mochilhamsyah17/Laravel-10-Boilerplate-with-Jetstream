@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <span class="font-bold">Users</span>
            </div>
            <div class="card-body ">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>
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