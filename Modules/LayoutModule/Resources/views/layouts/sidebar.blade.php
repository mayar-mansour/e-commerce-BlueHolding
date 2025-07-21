<nav class="pc-sidebar pc-trigger pt-2">
    <div class="navbar-wrapper mt-4">
        <div class="m-header mb-1">
            <a href="{{ route('dashboard.index') }}" class="b-brand text-primary logo_div">
                <img src="{{ asset('/assets/images/logo-esf-300.jpeg') }}" alt="Logo" class="img-fluid" style="max-width: 120px;">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item mt-4">
                    <a href="{{ route('dashboard.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                    <li class="pc-item">
                        <a href="{{ route('products.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-boxes"></i></span>
                            <span class="pc-mtext">Manage Products</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('orders.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-shopping-cart"></i></span>
                            <span class="pc-mtext">Manage Orders</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('admin.users.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-users"></i></span>
                            <span class="pc-mtext">User Management</span>
                        </a>
                    </li>







            </ul>
        </div>
    </div>
</nav>
