@extends('adminpost::edit')

@section('custom-fields-left')
    @include('adminpost::types.Device.includes.form-left')
@endsection

@section('custom-fields-right')
    @include('adminpost::types.Device.includes.form-right')
@endsection