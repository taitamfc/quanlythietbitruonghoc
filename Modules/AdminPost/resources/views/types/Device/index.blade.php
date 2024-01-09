@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Danh sách thiết bị',
'actions' => [
'add_new' => route($route_prefix.'create',['type'=>request()->type]),
]
])

<!-- Item actions -->
<form action="{{ route($route_prefix.'index') }}" method="get">
    <input type="hidden" name="type" value="{{ request()->type }}">
    <div class="row">
        <div class="col">
            <label class="form-label fw-bold">Tên Thiết Bị</label>
            <input class="form-control" name="name" type="text" placeholder="Nhập tên sau đó nhấn enter để tìm"
                value="{{ request()->name }}">
        </div>
        <div class="col">
            <label class="form-label fw-bold">Loại Thiết Bị</label>
            <x-admintheme::form-input-device-types name="device_type_id" selected_id="{{ request()->device_type_id }}"
                autoSubmit="1" />
        </div>
        <div class="col">
            <label class="form-label fw-bold">Môn Học</label>
            <x-admintheme::form-input-departments name="department_id" selected_id="{{ request()->department_id }}"
                autoSubmit="1" />
        </div>
        <div class="col col-lg-2">
            <label class="form-label fw-bold">Trạng Thái</label>
            <x-admintheme::form-input-status name="status" status="{{ request()->status }}"
                autoSubmit="1" />
        </div>
    </div>
</form>

<div class="card mt-4">
    <div class="card-body">
        <div class="product-table">
            <div class="table-responsive white-space-nowrap">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tên</th>
                            <th>Số lượng</th>
                            <th>Loại thiết bị</th>
                            <th>Bộ môn</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count( $items ) )
                        @foreach( $items as $key => $item )
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->devicetype->name ?? '' }}</td>
                            <td>{{ $item->department->name ?? '' }}</td>
                            <td>{!! $item->status_fm !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle dropdown-toggle-nocaret"
                                        type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route($route_prefix.'edit',['adminpost'=>$item->id,'type'=>request()->type]) }}">
                                                {{ __('sys.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route($route_prefix.'destroy',['adminpost'=>$item->id,'type'=>request()->type]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick=" return confirm('{{ __('sys.confirm_delete') }}') "
                                                    class="dropdown-item">
                                                    {{ $item->deleted_at ? __('sys.force_delete') : __('sys.delete') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center">{{ __('sys.no_item_found') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if( count( $items ) )
    <div class="card-footer pb-0">
        @include('admintheme::includes.globals.pagination')
    </div>
    @endif
</div>

@endsection