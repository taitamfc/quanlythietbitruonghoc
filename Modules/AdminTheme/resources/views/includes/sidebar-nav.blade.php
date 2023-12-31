<!--navigation-->
<ul class="metismenu" id="menu">
    <li class="menu-label">Giáo Viên</li>
    <li>
        <a href="{{ route('borrows.create') }}">
            <div class="parent-icon">
                <span class="material-symbols-outlined">dashboard</span>
            </div>
            <div class="menu-title">Trang Chủ</div>
        </a>
    </li>
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <div class="menu-title">Mượn Thiết Bị</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('borrows.create') }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tạo Phiếu Mượn
                </a>
            </li>
            <li>
                <a href="{{ route('borrows.index') }}">
                    <span class="material-symbols-outlined">arrow_right</span>Phiếu Mượn
                </a>
            </li>
        </ul>
    </li>
    <li class="menu-label">Quản Lý</li>
    <li>
        <a href="{{ route('borrows.create') }}">
            <div class="parent-icon">
                <span class="material-symbols-outlined">dashboard</span>
            </div>
            <div class="menu-title">Trang Tổng Quan</div>
        </a>
    </li>
    <!-- <li class="menu-label">Quản Lý Mượn Thiết Bị</li> -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">backup_table</span>
            </div>
            <div class="menu-title">Quản Lý Mượn</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('adminborrow.index') }}">
                    <span class="material-symbols-outlined">arrow_right</span>Phiếu Mượn
                </a>
            </li>
            <li>
                <a href="{{ route('adminborrow.index') }}">
                    <span class="material-symbols-outlined">arrow_right</span>Thiết Bị Mượn
                </a>
            </li>
        </ul>
    </li>
    <!-- <li class="menu-label">Quản Lý Trường Học</li> -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">home</span>
            </div>
            <div class="menu-title">Trường Học</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('adminpost.index',['type'=>'Device']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('adminpost.index',['type'=>'Asset']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tài Sản
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'Lab']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Phòng Học
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Nhóm Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'Room']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Lớp Học
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'Department']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Bộ Môn
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'Nest']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tổ
                </a>
            </li>
        </ul>
    </li>
    <!-- <li class="menu-label">Quản Lý Tài Khoản</li> -->
    <li>
        <a class="has-arrow" aria-expanded="false" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">account_circle</span>
            </div>
            <div class="menu-title">Tài Khoản</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('adminuser.index') }}">
                    <span class="material-symbols-outlined">arrow_right</span>Người Dùng 
                </a>
            </li>
            <a href="{{ route('adminuser.index') }}">
                <span class="material-symbols-outlined">arrow_right</span>Nhóm Người Dùng
            </a>
        </ul>
    </li>
    <!-- <li class="menu-label">Báo Cáo</li> -->
    <!-- <li class="menu-label">Công Cụ Nhập/Xuất</li> -->
    <!-- Nhập Dữ Liệu -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">swipe_up</span>
            </div>
            <div class="menu-title">Nhập Dữ Liệu</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('adminimport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('adminimport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tài Sản
                </a>
            </li>
            <li>
                <a href="{{ route('adminimport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Phòng Thực Hành
                </a>
            </li>
            <li>
                <a href="{{ route('adminimport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Nhóm Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('adminimport.index',['type'=>'Room']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Lớp Học
                </a>
            </li>
            <li>
                <a href="{{ route('adminimport.index',['type'=>'Department']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Bộ Môn
                </a>
            </li>
            <li>
                <a href="{{ route('adminimport.index',['type'=>'Nest']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tổ
                </a>
            </li>
        </ul>
    </li>
    <!-- Xuất Dữ Liệu -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">swipe_down</span>
            </div>
            <div class="menu-title">Xuất Dữ Liệu</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('adminexport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('adminexport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tài Sản
                </a>
            </li>
            <li>
                <a href="{{ route('adminexport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Phòng Thực Hành
                </a>
            </li>
            <li>
                <a href="{{ route('adminexport.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Nhóm Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('adminexport.index',['type'=>'Room']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Lớp Học
                </a>
            </li>
            <li>
                <a href="{{ route('adminexport.index',['type'=>'Department']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Bộ Môn
                </a>
            </li>
            <li>
                <a href="{{ route('adminexport.index',['type'=>'Nest']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Tổ
                </a>
            </li>
        </ul>
    </li>
    <!-- <li class="menu-label">Cấu Hình Hệ Thống</li> -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">settings_applications</span>
            </div>
            <div class="menu-title">Cấu Hình</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Đơn Vị
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Mượn Thiết Bị
                </a>
            </li>
            
        </ul>
    </li>
    <!-- <li class="menu-label">Hướng Dẫn Sử Dụng</li> -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <span class="material-symbols-outlined">shop</span>
            </div>
            <div class="menu-title">Hướng Dẫn</div>
        </a>
        <ul class="mm-collapse">
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Cài Đặt
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Giáo Viên
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Nhân Viên Thiết Bị
                </a>
            </li>
            <li>
                <a href="{{ route('admintaxonomy.index',['type'=>'DeviceType']) }}">
                    <span class="material-symbols-outlined">arrow_right</span>Quản Trị Viên
                </a>
            </li>
        </ul>
    </li>
</ul>
<!--end navigation-->