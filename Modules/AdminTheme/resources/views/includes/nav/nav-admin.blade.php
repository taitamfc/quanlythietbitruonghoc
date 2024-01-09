<li class="menu-label">Quản Lý</li>
<li>
    <a href="{{ route('admin.home') }}">
        <div class="parent-icon">
            <span class="material-symbols-outlined">dashboard</span>
        </div>
        <div class="menu-title">Trang Tổng Quan</div>
    </a>
</li>
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
            <a href="{{ route('adminborrow.devices') }}">
                <span class="material-symbols-outlined">arrow_right</span>Thiết Bị Mượn
            </a>
        </li>
        <li>
            <a href="{{ route('adminborrow.labs') }}">
                <span class="material-symbols-outlined">arrow_right</span>Phòng Mượn
            </a>
        </li>
    </ul>
</li>
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
        <a href="{{ route('admingroup.index') }}">
            <span class="material-symbols-outlined">arrow_right</span>Nhóm Người Dùng
        </a>
    </ul>
</li>
<li>
    <a class="has-arrow" href="javascript:;">
        <div class="parent-icon">
            <span class="material-symbols-outlined">swipe_up</span>
        </div>
        <div class="menu-title">Nhập Dữ Liệu</div>
    </a>
    <ul class="mm-collapse">
        <li>
            <a href="{{ route('adminimport.index',['type'=>'Nest']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Tổ
            </a>
        </li>
        <li>
            <a href="{{ route('adminimport.index',['type'=>'Department']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Bộ Môn
            </a>
        </li>
        <li>
            <a href="{{ route('adminimport.index',['type'=>'Room']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Lớp Học
            </a>
        </li>
        <li>
            <a href="{{ route('adminimport.index',['type'=>'DeviceType']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Nhóm Thiết Bị
            </a>
        </li>
        <li>
            <a href="{{ route('adminimport.index',['type'=>'Lab']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Phòng Thực Hành
            </a>
        </li>
        <li>
            <a href="{{ route('adminimport.index',['type'=>'Asset']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Tài Sản
            </a>
        </li>
        <li>
            <a href="{{ route('adminimport.index',['type'=>'Device']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Thiết Bị
            </a>
        </li>
    </ul>
</li>
<li>
    <a class="has-arrow" href="javascript:;">
        <div class="parent-icon">
            <span class="material-symbols-outlined">swipe_down</span>
        </div>
        <div class="menu-title">Xuất Dữ Liệu</div>
    </a>
    <ul class="mm-collapse">
        <li>
            <a href="{{ route('adminexport.index',['type'=>'BorrowDevicesNest']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Sổ Mượn Tổ
            </a>
        </li>
        <li>
            <a href="{{ route('adminexport.index',['type'=>'BorrowDevicesUser']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Sổ Mượn Giáo Viên
            </a>
        </li>
        <!-- <li>
            <a href="{{ route('adminexport.index',['type'=>'BorrowLab']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Sổ Mượn Phòng Bộ Môn
            </a>
        </li> -->
        <li>
            <a href="{{ route('adminexport.index',['type'=>'BorrowDevice']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Sổ Mượn Thiết Bị
            </a>
        </li>
        <li>
            <a href="{{ route('adminexport.index',['type'=>'BorrowDetail']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Phiếu Báo Mượn
            </a>
        </li>
    </ul>
</li>
<li>
    <a class="has-arrow" href="javascript:;">
        <div class="parent-icon">
            <span class="material-symbols-outlined">settings_applications</span>
        </div>
        <div class="menu-title">Hệ Thống</div>
    </a>
    <ul class="mm-collapse">
        <li>
            <a href="{{ route('system.options.index',['type'=>'general']) }}">
                <span class="material-symbols-outlined">arrow_right</span>Cấu Hình
            </a>
        </li>
        <li>
            <a href="{{ route('system.update.index') }}">
                <span class="material-symbols-outlined">arrow_right</span>Cập Nhật
            </a>
        </li>
        <li>
            <a target="_blank" href="https://huongdan.quanlythietbitruonghoc.com/">
                <span class="material-symbols-outlined">arrow_right</span>Hướng Dẫn
            </a>
        </li>
    </ul>
</li>