@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Xuất: '.__(request()->type),
'actions' => []
])
<div class="card mt-4">
    <div class="card-body">
        <form action="{{ route($route_prefix.'store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ request()->type }}">
            <div class="mb-4">
                <h5 class="mb-4">Bạn đang chuẩn bị xuất dữ liệu cho: {{ __(request()->type) }}</h5>
                <p class="mb-0">Dữ liệu xuất sẽ được lưu vào file excel</p>
                <p class="mt-0">Nhấn vào <a target="_blank" href="{{ asset('system/export/'.$templateFile) }}">đây</a>
                    để xem tệp mẫu </p>
            </div>
            @yield('form-fields')
            <div class="mb-4">
                <div class="d-md-flex d-grid align-items-center gap-3">
                    <a href="{{ route('adminexport.index',[ 'type'=> request()->type ]) }}" class="btn btn-dark">Quay
                        lại</a>
                    <button class="btn btn-primary px-4">Tiến Hành</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection