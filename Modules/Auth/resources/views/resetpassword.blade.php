@extends('admintheme::layouts.auth')
@section('content')
<!-- Login Form -->
<div class="login-form default-form">
    <div class="form-inner">
        <h3>Reset password</h3>
        <!--Login Form-->
        <form action="{{ route('website.postReset',['user' => $data['user'],'token' => $data['token']]) }}" method="POST">
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
            @csrf
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="password">
                @if ($errors->any())
                <p style="color:red">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="repeatpassword" value="{{ old('password') }}"placeholder="Confirm Password">
                @if ($errors->any())
                <p style="color:red">{{ $errors->first('repeatpassword') }}</p>
                @endif
            </div>

            <div class="form-group">
                <div class="field-outer">
                    <div class="text">Don't have an account? <a href="{{ route('website.register')}}">Signup</a></div>
                </div>
            </div>
            <div class="form-group">
                <button class="theme-btn btn-style-one" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
<!--End Login Form -->
@endsection