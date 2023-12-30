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
                <input class="form-control" type="search" name="name" placeholder="Tìm thiết bị"
                    value="{{ request()->name }}">
            </div>
        </form>
    </div>
    <div class="col-8">
    <form class="row" action="" method="get">
            <div class="col-lg-4">
                <select class="form-control" onchange="this.form.submit()" name='qty'>
                    <option @selected( request()->qty === '' ) value="">Tình trạng</option>
                    <option value="1" @selected( request()->qty == 1 )> Thiết bị còn</option>
                    <option value="0" @selected( request()->qty !== "" && request()->qty === '0' )> Thiết bị đã hết</option>
                </select>
            </div>
            <div class="col-lg-4">
                <select class="form-control" onchange="this.form.submit()" name='device_type_id'>
                    <option value="">Loại thiết bị</option>
                    @foreach($device_types as $device_type)
                    <option value="{{$device_type->id}}"
                        @selected($device_type->id == request()->device_type_id)>
                        {{ $device_type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <select class="form-control" onchange="this.form.submit()" name='department_id'>
                    <option value="">Môn học</option>
                    @foreach($departments as $department)
                    <option value="{{$department->id}}"
                        @selected($department->id == request()->department_id)>
                        {{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
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
                            <th width="300px">Tên thiết bị</th>
                            <th>Số lượng</th>
                            <th>Loại thiết bị</th>
                            <th>Bộ môn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item )
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->device_type_name }}</td>
                            <td>{{ $item->department_name }}</td>
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