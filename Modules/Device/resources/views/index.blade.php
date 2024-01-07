@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
    'page_title' => 'Danh sách thiết bị',
    'actions' => []
])
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