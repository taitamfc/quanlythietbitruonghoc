<li class="menu-label">Giáo Viên</li>
<li>
    <a href="{{ route('home') }}">
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
<li>
    <a href="{{ route('borrows.labs') }}">
        <div class="parent-icon">
            <span class="material-symbols-outlined">calendar_month</span>
        </div>
        <div class="menu-title">Lịch Sử Dụng Phòng</div>
    </a>
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
            <a href="{{ route('devices.index') }}">
                <span class="material-symbols-outlined">arrow_right</span>Thiết Bị
            </a>
        </li>
        <li>
            <a href="{{ route('labs.index') }}">
                <span class="material-symbols-outlined">arrow_right</span>Phòng Học
            </a>
        </li>
    </ul>
</li>
