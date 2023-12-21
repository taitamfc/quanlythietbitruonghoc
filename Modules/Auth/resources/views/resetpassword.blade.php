@extends('admintheme::layouts.auth')
@section('content')
<h3 class="fw-bold text-center">ĐẶT LẠI MẬT KHẨU</h3>
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
    <form class="row g-3" action="{{ route('auth.postReset',[$user,$token]) }}" method="POST">
        @csrf
        <div class="col-12">
            <label for="email" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="email" placeholder="******" name="password">
            @error('password')
            <a style="color:red" class='form-control'>{{ $errors->first('password') }}</a>
            @enderror
        </div>
        <div class="col-12">
            <label for="email" class="form-label">Nhập lại mật khẩu</label>
            <input type="password" class="form-control" id="email" placeholder="******" name="repeatpassword">
            @error('repeatpassword')
            <a style="color:red" class='form-control'>{{ $errors->first('repeatpassword') }}</a>
            @enderror
        </div>
        <div class="col-12">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Gửi Yêu Cầu</button>
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