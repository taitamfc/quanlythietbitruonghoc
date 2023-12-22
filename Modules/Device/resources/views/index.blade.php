@extends('admintheme::layouts.master')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Danh sách thiết bị</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Thiết bị</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-primary">Settings</button>
            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                <a class="dropdown-item" href="javascript:;">Action</a>
                <a class="dropdown-item" href="javascript:;">Another action</a>
                <a class="dropdown-item" href="javascript:;">Something else here</a>
                <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
            </div>
        </div>
    </div> -->
</div>
<!--end breadcrumb-->

<!-- Item actions -->
<div class="row">
    <div class="col-4">
        <form action="" method="get">
            <div class="position-relative">
                <input class="form-control px-5" type="search" name="searchName" placeholder="Tìm thiết bị"
                    value="{{ $request->searchName ? $request->searchName : '' }}">
                <span
                    class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
            </div>
        </form>
    </div>
    <div class="col-8 d-flex">
        <form class="col border rounded" action="" method="get">
            <select class="form-control" onchange="this.form.submit()" name='searchQuantity'>
                <option disabled selected>Tình trạng</option>
                <option value="1"
                    {{ isset($request->searchQuantity) && $request->searchQuantity == 1 ? "selected" : '' }}>
                    Thiết bị còn</option>
                <option value="0"
                    {{ isset($request->searchQuantity) && $request->searchQuantity == 0 ? "selected" : '' }}>
                    Thiết bị đã hết</option>
            </select>
        </form>
        <form class="col border rounded" action="" method="get">
            <select class="form-control" onchange="this.form.submit()" name='searchDeviceType'>
                <option disabled selected>Loaị thiết bị</option>
                @foreach($device_types as $device_type)
                <option value="{{$device_type->id}}"
                    {{ isset($request->searchDeviceType) && $request->searchDeviceType == $device_type->id ? "selected" : '' }}>
                    {{ $device_type->name }}</option>
                @endforeach
            </select>
        </form>
        <form class="col border rounded" action="" method="get">
            <select class="form-control" onchange="this.form.submit()" name='searchDepartment'>
                <option disabled selected>Môn học</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}"
                    {{ isset($request->searchDepartment) && $request->searchDepartment == $department->id ? "selected" : '' }}>
                    {{ $department->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>
<!--end row-->

<div class="card mt-4">
    <div class="card-body">
        <div class="product-table">
            <div class="table-responsive white-space-nowrap">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên thiết bị</th>
                            <th>Số lượng</th>
                            <th>Loại thiết bị</th>
                            <th>Bộ môn</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item )
                        <tr>
                            <td>{{ $key }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="product-box">
                                        <img src=" {{ asset('asset/images/avatars/team1.jpg') }}" alt="">
                                    </div>
                                    {{ $item->name }}
                                    <!-- <p class="mb-0 product-category">Category : Fashion</p> -->
                                </div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->device_type_name }}</td>
                            <td>{{ $item->department_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary border" type="button">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('admintheme::includes.globals.pagination')
            </div>
        </div>
    </div>
</div>
@endsection