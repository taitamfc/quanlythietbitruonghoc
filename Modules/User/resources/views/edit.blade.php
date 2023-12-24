@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('website.users.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <h5 class="mb-3">Tên</h5>
                        <input type="text" class="form-control" value="{{ $item->name }}" name="name">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-3">Ngày sinh</h5>
                        <input type="date" class="form-control" value="{{ $item->birthday }}" name="birthday">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-3">Giới tính</h5>
                        <select name="gender" class="form-control">
                            <option value="Nam" {{ $item->gender == "Nam"?"selected":'' }}>Nam</option>
                            <option value="Nữ" {{ $item->gender == "Nữ"?"selected":'' }}>Nữ</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-3">Địa chỉ</h5>
                        <input type="text" class="form-control" value="{{ $item->address }}" name="address">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-3">Số điện thoại</h5>
                        <input type="number" class="form-control" value="{{ $item->phone }}" name="phone">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-3">Mật khẩu</h5>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-3">Ảnh đại diện</h5>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="mb-4 col-3">
                        <img src="{{ asset($item->image) }}" class="rounded-circle img-thumbnail">
                    </div>
                    <div class="mb-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end row-->
@endsection