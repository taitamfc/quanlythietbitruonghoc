@extends('admintheme::layouts.auth')
@section('content')
<h3 class="fw-bold text-center">QUẢN LÍ THIẾT BỊ</h3>
@if (session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
<div class="form-body mt-4">
    <form class="row g-3" action="{{ route('auth.postLogin') }}" method="POST">
        @csrf
        <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="jhon@example.com">
            @error('email')
            <a style="color:red" class='form-control'>{{ $errors->first('email') }}</a>
            @enderror
        </div>
        <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <div class="input-group" id="show_hide_password">
                <input type="password" class="form-control border-end-0" id="password" name="password" value=""
                    placeholder="Enter Password">
                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
            </div>
            @error('password')
            <a style="color:red" class='form-control'>{{ $errors->first('password') }}</a>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ghi nhớ mật khẩu</label>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('auth.forgot') }}">Quên mật khẩu?
            </a>
        </div>
        <div class="col-12">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('footer')
<script>
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
        }
    });
});
</script>
@endsection