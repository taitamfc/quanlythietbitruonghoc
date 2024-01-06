@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Thêm mới người dùng',
// 'actions' => [
// 'add_new' => route($route_prefix.'create',['type'=>request()->type]),
//'export' => route($route_prefix.'export'),
// ]
])

<form action="{{ route($route_prefix.'store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="{{ request()->type }}">
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