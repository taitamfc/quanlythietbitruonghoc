<li class="nav-item dropdown dropdown-large">
    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
        <div class="position-relative">
            <span class="notify-badge">{{ session('unreadCount', count($cr_notifications)) }}</span>
            <span class="material-symbols-outlined">
                notifications_none
            </span>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end mt-lg-2">
        <a href="javascript:;">
            <div class="msg-header">
                <p class="msg-header-title">Thông báo</p>
                <p class="msg-header-clear ms-auto">
                    <a href="{{ route('is_read') }}" class="text-decoration-none">
                        Đánh dấu tất cả là đã đọc
                    </a>
                </p>

            </div>
        </a>
        <div class="header-notifications-list">
            @foreach($cr_notifications as $notification)
            <a class="dropdown-item" href="{{ $notification->item_link }}">
                <div class="d-flex align-items-center">
                    <div class="notify text-primary border">
                        <span class="material-symbols-outlined">
                            {!! $notification->item_icon !!}
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="msg-name">{{ $notification->item_name }}
                            <span class="msg-time float-end">{{ $notification->created_at->diffForHumans() }}</span>
                        </h6>
                        <p class="msg-info">{!! $notification->item_description !!}</p>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
        <a href="javascript:;">
            <div class="text-center msg-footer">Xem tất cả</div>
        </a>
    </div>
</li>