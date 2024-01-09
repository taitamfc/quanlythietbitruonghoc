@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
    'page_title' => 'Chỉnh sửa người dùng',
])

<form action="{{ route($route_prefix.'update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 col-lg-8">
            @include('adminuser::adminuser.includes.form-left')
        </div>
        <div class="col-12 col-lg-4">
            @include('adminuser::adminuser.includes.form-right')
        </div>
    </div>
</form>

@endsection