<!--start sidebar-->
<aside class="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="assets/images/logo-icon.png" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">Roksyn</h5>
        </div>
        <div class="sidebar-close ">
            <span class="material-symbols-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">
        @include('admintheme::includes.sidebar-nav')
    </div>
    <div class="sidebar-bottom dropdown dropup-center dropup">
        <div class="dropdown-toggle d-flex align-items-center px-3 gap-3 w-100 h-100" data-bs-toggle="dropdown">
            <div class="user-img">
                <img src="assets/images/avatars/01.png" alt="">
            </div>
            <div class="user-info">
                <h5 class="mb-0 user-name">Jhon Maxwell</h5>
                <p class="mb-0 user-designation">UI Engineer</p>
            </div>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="javascript:;">
                <span class="material-symbols-outlined me-2"></span>
                <span>Profile</span>
            </a>
            </li>
            <li>
                <a class="dropdown-item" href="javascript:;">
                    <span class="material-symbols-outlined me-2"></span>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!--end sidebar-->