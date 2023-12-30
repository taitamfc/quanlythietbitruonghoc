@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb')
<form action="{{ route('adminpost.update',$item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="type" value="{{ request()->type }}">
    <div class="row">
        <div class="col-12 col-lg-8">
            @include('adminpost::includes.form-left')
        </div>
        <div class="col-12 col-lg-4">
        @include('adminpost::includes.form-right')
        </div>
    </div>
</form>
<!--end row-->
@endsection