<!-- Sidebar -->
<div class="sidebar d-flex flex-column justify-between">
    <div class="nav flex-column">
        <a href="{{route('dashboard')}}" class="sidebar-link active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{route('pemesanan.index')}}" class="sidebar-link active">
            <i class="fa-solid fa-cart-shopping"></i> Pemesanan
        </a>
        <a href="{{route('topping.index')}}" class="sidebar-link active">
            <i class="fa-solid fa-comments-dollar"></i> Topping
        </a>
        <a href="{{route('inventory.index')}}" class="sidebar-link active">
            <i class="fa-solid fa-warehouse"></i> Inventory
        </a>
        <a href="{{route('user.index')}}" class="sidebar-link active">
            <i class="fa-solid fa-users"></i> User
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-link text-start w-100">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>

        </form>
    </div>
</div>