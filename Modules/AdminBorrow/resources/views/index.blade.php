@extends('admintheme::layouts.master')
@section('content')
    @include('admintheme::includes.globals.breadcrumb',[
        'page_title' => 'Danh sách phiếu',
        'actions' => [
            //'add_new' => route($route_prefix.'create'),
            //'export' => route($route_prefix.'export'),
        ]
    ])

    <!-- Item actions -->
    <form action="{{ route($route_prefix.'index') }}" method="get">
        <p class="mb-2">Lưu ý: Chỉ tìm kiếm một trong hai trường Tuần và Năm</p>
        <div class="row">
               <div class="col col-12 col-md-2">
                <label class="form-label fw-bold">Giáo Viên</label>
                <x-admintheme::form-input-users name="user_id" selected_id="{{ request()->user_id }}" autoSubmit="true"/>
            </div>
               <div class="col col-12 col-md-2">
                <label class="form-label fw-bold">Tổ</label>
                <x-admintheme::form-input-nests name="nest_id" selected_id="{{ request()->nest_id }}" autoSubmit="true"/>
            </div>
               <div class="col col-12 col-md-2">
                <label class="form-label fw-bold">Buổi</label>
                <select name="session" class="form-control" onchange="this.form.submit()">
                    <option value="">---</option>
                    <option @selected(request()->session == 'AM') value="AM">Sáng</option>
                    <option @selected(request()->session == 'PM') value="PM">Chiều</option>
                </select>
            </div>
               <div class="col col-12 col-md-2">
                <label class="form-label fw-bold">Ngày dạy : Tuần</label>
                <input type="week" min="2022-W01" max="{{ date('Y') }}-W99" name="week" class="form-control" value="{{ request()->week }}" onchange="this.form.submit()">
            </div>
               <div class="col col-12 col-md-2">
                <label class="form-label fw-bold">Ngày dạy : Năm</label>
                <x-admintheme::form-input-school-years name="school_years" selected_id="{{ request()->school_years }}" autoSubmit="true"/>
            </div>
               <div class="col col-12 col-md-2">
                <label class="form-label fw-bold">Trạng thái</label>
                <select name="status" class="form-control" onchange="this.form.submit()">
                    <option value="">---</option>
                    <option @selected(request()->status == $model::ACTIVE) value="{{ $model::ACTIVE   }}">Duyệt</option>
                    <option @selected(request()->status !== NULL && request()->status == $model::INACTIVE) value="{{ $model::INACTIVE }}">Chờ</option>
                    <option @selected(request()->status == $model::CANCELED) value="{{ $model::CANCELED }}">Hủy</option>
                </select>
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
                                <th width="15%">Người mượn</th>
                                <th width="12%">Ngày dạy</th>
                                <th>Thiết bị</th>
                                <th width="20%">Phòng bộ môn</th>
                                <th width="10%"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if( count( $items ) )
                            @foreach( $items as $key => $item )
                            <tr>
                                <td>#{{ $item->id }}</td>
                                <td>
                                    {{ $item->user_name }}
                                    <p class="mb-0 product-category">{{ $item['created_at_fm'] }}</p>
                                </td>
                                <td>{{ $item->borrow_date_fm }}</td>
                                <td>{!! $item->device_names !!}</td>
                                <td>{!! $item->lab_names !!}</td>
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
                                            <li>
                                                <a class="dropdown-item" href="{{ route($route_prefix.'edit',$item->id) }}">
                                                    {{ __('borrow::sys.edit') }}        
                                                </a>
                                            </li>
                                            @if( $item->status == $model::INACTIVE )
                                            <li>
                                                <a onclick=" return confirm('{{ __('Bạn có chắc chắn duyệt phiếu này !') }}') " class="dropdown-item" href="{{ route($route_prefix.'index',['task'=>'approve','id'=>$item->id]) }}">
                                                    {{ __('borrow::sys.approve') }}        
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <form action="{{ route($route_prefix.'destroy',$item->id) }}" method="post">
                                                    @csrf
                                                    @if($item->status == $model::CANCELED)
                                                        @method('DELETE')    
                                                    @else
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="{{ $model::CANCELED }}">
                                                    @endif
                                                    <button onclick=" return confirm('{{ $item->status == $model::CANCELED ? __('adminborrow::sys.force_delete') : __('adminborrow::sys.confirm_canceled') }}') " class="dropdown-item">
                                                    {{ $item->status == $model::CANCELED ? __('sys.force_delete') : 'Hủy phiếu' }}   
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