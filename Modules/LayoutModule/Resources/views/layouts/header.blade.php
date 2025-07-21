<header class="pc-header">
    <div class="header-wrapper">
        <!-- Sidebar toggles for desktop/mobile -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- User dropdown -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item d-flex align-items-center">
                    <span class="greeting me-3" style="font-size: 1rem; color: #2c3e50;">
                        Welcome, 
                        <strong class="text-primary ms-1">{{ Auth::guard('web')->user()->email }}</strong>
                    
                    </span>
                </li>

                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/user/user_avatar.png') }}" alt="User Avatar" class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="{{ route('changePassword') }}" class="dropdown-item">
                                    <i class="ph-duotone ph-key me-2"></i> Change Password
                                </a>
                            </li>
                            <li class="list-group-item">
                                <form action="{{ route('logout') }}" method="GET">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="ph-duotone ph-sign-out me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
