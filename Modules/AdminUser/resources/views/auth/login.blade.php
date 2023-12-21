@extends('admintheme::layouts.auth')
@section('content')
    <img src="assets/images/logo-icon.png" class="mb-4" width="45" alt="">
    <h4 class="fw-bold">Get Started Now</h4>
    <p class="mb-0">Enter your credentials to login your account</p>
    <div class="row g-3 my-4">
        <div class="col-12 col-lg-6">
            <button class="btn btn-primary py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100">Log In
                with Google</button>
        </div>
        <div class="col-12 col-lg-6">
            <button class="btn btn-primary py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100">Log In
                with Facebook</button>
        </div>
    </div>

    <div class="separator section-padding">
        <div class="line"></div>
        <p class="mb-0 fw-bold">OR</p>
        <div class="line"></div>
    </div>

    <div class="form-body mt-4">
        <form class="row g-3" action="{{ route('adminuser.postLogin') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="jhon@example.com">
            </div>
            <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <div class="input-group" id="show_hide_password">
                    <input type="password" class="form-control border-end-0" id="password" name="password" value="12345678"
                        placeholder="Enter Password">
                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
            </div>
            <div class="col-md-6 text-end"> 
                <a href="{{ route('adminuser.forgotPass') }}">Forgot
                    Password ?
                </a>
            </div>
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
            <div class="col-12">
                <div class="text-start">
                    <p class="mb-0">Don't have an account yet? <a href="{{ route('adminuser.register') }}">Sign up here</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer')
<script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
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