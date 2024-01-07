@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
    'page_title' => 'Danh sách nhóm người dùng',
    'actions' => [
        'back' => route($route_prefix.'index',['type'=>request()->type]),
    ]
])

<!-- Item actions -->

<div class="card">
    <div class="card-header">
        <div class="text-uppercase fw-bold">Chỉnh sửa tên nhóm người dùng</div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <form action="{{ route($route_prefix.'update', ['admingroup' => $item->id, 'type' => request()->type]) }}" method="post">
                @csrf
                @method('PUT')
                <label class="mb-3">{{ __('adminpost::form.name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}">
                <x-admintheme::form-input-error field="name"/>
                <button class="btn btn-primary px-4 mt-3">Cập nhật</button>
            </form>
        </div>
    </div>
</div>


@endsection



