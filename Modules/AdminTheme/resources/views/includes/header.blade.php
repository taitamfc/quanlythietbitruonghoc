<!--start header-->
<header class="top-header">
    <nav class="navbar navbar-expand justify-content-between">
        <div class="btn-toggle-menu">
            <span class="material-symbols-outlined">menu</span>
        </div>
        <div class="d-lg-block d-none search-bar" style="width:80%">
            <marquee behavior="" direction="">Chúc bạn một ngày làm việc hiệu quả !</marquee>
        </div>
        <ul class="navbar-nav top-right-menu gap-2">
            <li class="nav-item d-lg-none d-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <a class="nav-link" href="javascript:;"><span class="material-symbols-outlined">
                        search
                    </span></a>
            </li>
            <li class="nav-item dark-mode">
                <a class="nav-link dark-mode-icon" href="javascript:;"><span
                        class="material-symbols-outlined">dark_mode</span></a>
            </li>

            @include('admintheme::includes.notifications')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                    <a class="dropdown-item" href="{{ route('users.index') }}">
                        <span class="material-symbols-outlined me-2"></span>
                        <span>Tài Khoản</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">
                        <span class="material-symbols-outlined me-2"></span>
                        <span>Thoát</span>
                    </a>
                </div>
                <style>
                .dropdown-toggle::after {
                    content: none;
                }
                </style>
            </li>
        </ul>
    </nav>
</header>
<!--end header-->