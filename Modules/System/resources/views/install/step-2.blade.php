@extends('admintheme::layouts.auth')
@section('content')
    <h4 class="fw-bold text-center">Cài đặt thông tin quản trị</h4>
    <p class="mb-2 text-center">Chức năng chưa chạy được, hehe</p>
    <div class="separator section-padding">
        <div class="line"></div>
    </div>

    <div class="form-body text-center mt-4">
        <div class="spinner-grow text-primary" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-success" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-danger" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-warning" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-info" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-light" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-dark" role="status"> 
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.home') }}" type="submit" class="btn btn-warning">Hủy cài đặt</a>
    </div>
@endsection
@section('footer')
<script>
    jQuery( document ).ready( function(){
        let urlInstall = '{{ route($route_prefix."doInstall") }}';
        let step = '{{ $step }}';
        // jQuery.ajax({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     url: urlInstall,
        //     type: "GET",
        //     dataType:'json',
        //     data: {
        //         'step' : step
        //     },
        //     success: function (res) {
        //         if( res.success ){
        //             window.location.href = res.redirect;
        //         }
        //     }
        // });
    })
</script>
@endsection