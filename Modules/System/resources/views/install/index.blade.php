@extends('admintheme::layouts.auth')
@section('content')
    <h4 class="fw-bold text-center">Cài Đặt Hệ Thống</h4>

    <div class="separator section-padding">
        <div class="line"></div>
    </div>

    <div class="form-body mt-4">
        <form class="row g-3" method="GET" action="{{ route('system.install.doInstall') }}">
            <input type="hidden" name="step" value="1">
            <div class="col-12">
                <div class="text-center">
                    <p class="mb-0">Lưu ý: <br> Không tắt trình duyệt khi quá trình cài đặt đang diễn ra</p>
                </div>
            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Bắt đầu cài đặt</button>
                </div>
            </div>
            
        </form>
    </div>
@endsection