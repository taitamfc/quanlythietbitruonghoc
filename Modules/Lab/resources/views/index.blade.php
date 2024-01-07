@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Danh sách phòng học',
'actions' => []
])

<!-- Item actions -->
<form class="form-search" action="{{ route('labs.index') }}" method="get">
    <div class="row">
        <div class="col col-lg-3">
            <label class="form-label">Phân Loại</label>
            <select  class="form-control f-filter" name='department_id'>
                <option value="">Môn học</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}" @selected($department->id == request()->department_id)>
                    {{ $department->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

</form>

<div class="card mt-4">
    <div class="card-body">
        <div class="product-table">
            <div class="table-responsive white-space-nowrap mt-2">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th width="300px">Tên phòng học</th>
                            <th>Bộ môn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $key => $item )
                        <tr data-quantity="1" data-name="{{ $item->name }}"
                            data-device_type_name="{{ $item->device_type_name }}"
                            data-department_name="{{ $item->department_name }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->department->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer pb-0">
        @include('admintheme::includes.globals.pagination')
    </div>
</div>

@endsection