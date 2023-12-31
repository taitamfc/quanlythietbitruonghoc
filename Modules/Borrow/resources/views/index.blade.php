@extends('admintheme::layouts.master')
@section('content')
    @include('admintheme::includes.globals.breadcrumb',[
        'page_title' => 'Danh sách phiếu',
        'actions' => [
            'add_new' => route($route_prefix.'create'),
            //'export' => route($route_prefix.'export'),
        ]
    ])

    <!-- Item actions -->
    <form action="{{ route($route_prefix.'index') }}" method="get">
        <div class="row g-3">
            <div class="col-auto flex-grow-1">
                <div class="position-relative">
                    <input class="form-control" name="name" type="text" placeholder="Search name">
                </div>
            </div>
            <div class="col-auto">
                <x-admintheme::form-status model="{{ $model }}" status="{{ request()->status }}" showAll="1"/>
            </div>
            <div class="col-auto">
                <select class="form-control dropdown-toggle" name="sortBy">
                    <option value="" @selected( request()->sortBy == '' )>{{ __('sys.sort_default') }}</option>
                    <option value="id_asc" @selected( request()->sortBy == 'id_asc' )>{{ __('sys.id_asc') }}</option>
                    <option value="name_asc" @selected( request()->sortBy == 'name_asc' )>{{ __('sys.name_asc') }}</option>
                    <option value="created_asc" @selected( request()->sortBy == 'created_asc' )>{{ __('sys.created_asc') }}</option>
                </select>
            </div>
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2 justify-content-lg-end">
                    <button class="btn btn-light px-4"><i class="bi bi-box-arrow-right me-2"></i>Search</button>
                </div>
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
                                <th>STT</th>
                                <th>Người mượn</th>
                                <th>Ngày tạo phiếu</th>
                                <th>Ngày dạy</th>
                                <th>Số thiết bị</th>
                                <th>Xét duyệt</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if( count( $items ) )
                            @foreach( $items as $key => $item )
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->user_name }}</td>
                                <td>{{ $item->created_at_fm }}</td>
                                <td>{{ $item->borrow_date_fm }}</td>
                                <td>{{ $item->number_devices }}</td>
                                <td>{!! $item->status_fm !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border dropdown-toggle dropdown-toggle-nocaret"
                                            type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route($route_prefix.'show',$item->id) }}">
                                                    {{ __('borrow::sys.show') }}        
                                                </a>
                                            </li>
                                            @if( $item->status < 0 )
                                            <li>
                                                <a class="dropdown-item" href="{{ route($route_prefix.'edit',$item->id) }}">
                                                    {{ __('borrow::sys.edit') }}     
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route($route_prefix.'destroy',$item->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick=" return confirm('{{ __('sys.confirm_delete') }}') " class="dropdown-item">
                                                        {{ __('borrow::sys.delete') }} 
                                                    </button>
                                                </form>
                                            </li>
                                            @endif

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
        <div class="card-footer pb-0">
            @include('admintheme::includes.globals.pagination')
        </div>
    </div>

@endsection