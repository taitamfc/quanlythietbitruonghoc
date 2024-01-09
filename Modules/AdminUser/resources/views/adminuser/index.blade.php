@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
        'page_title' => 'Người dùng',
        'actions' => [
        'add_new' => route($route_prefix.'create',['type'=>request()->type]),
    ]
])

<!-- Item actions -->
<form action="{{ route($route_prefix.'index') }}" method="get">
    <input type="hidden" name="type" value="{{ request()->type }}">
    <div class="row">
        <div class="col">
            <label class="form-label fw-bold">Tên</label>
            <input class="form-control" name="name" type="text" placeholder="Nhập tên sau đó nhấn enter để tìm"
                    value="{{ request()->name }}">
        </div>
        <div class="col">
            <label class="form-label fw-bold">Nhóm</label>
            <x-admintheme::form-input-groups status="{{ request()->group_id }}" autoSubmit="1" />
        </div>
        <div class="col col-lg-2">
            <label class="form-label fw-bold">Trạng thái</label>
            <x-admintheme::form-input-status status="{{ request()->status }}" autoSubmit="1" />
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
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th>Nhóm</th>
                            <th>Ngày tạo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( count( $items ) )
                        @foreach( $items as $item )
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->group->name ?? '' }}</td>
                            <td>{{ $item->created_at_fm }}</td>
                            <td>{!! $item->status_fm !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle dropdown-toggle-nocaret"
                                        type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route($route_prefix.'edit',$item->id) }}">
                                                {{ __('sys.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route($route_prefix.'destroy',$item->id) }}" method="post">
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