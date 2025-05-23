<!-- Sidebar -->
<div class="sidebar d-flex flex-column justify-between">
    <div class="nav flex-column">
        <a href="{{route('dashboard')}}" class="sidebar-link active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-link text-start w-100">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>

        </form>
    </div>
</div>