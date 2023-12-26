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
                                <th>Ngày tạo phiếu</th>
                                <th>Ngày dạy</th>
                                <th>Tình trạng</th>
                                <th>Xét duyệt</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if( count( $items ) )
                            @foreach( $items as $item )
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="product-box">
                                            <img src="{{ $item->image_fm }}" alt="">
                                        </div>
                                        <div class="product-info">
                                            <a href="javascript:;" class="product-title">{{ $item->name }}</a>
                                            <p class="mb-0 product-category">(0)</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{!! $item->status_fm !!}</td>
                                <td>{{ $item->created_at_fm }}</td>
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
                                                    <button onclick=" return confirm('{{ __('sys.confirm_delete') }}') " class="dropdown-item">
                                                        {{ __('sys.delete') }}   
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
        <div class="card-footer pb-0">
            @include('admintheme::includes.globals.pagination')
        </div>
    </div>

@endsection