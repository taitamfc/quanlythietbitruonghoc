@extends('adminpost::create')

@section('custom-fields-left')
    @include('adminpost::types.Asset.includes.form-left')
@endsection

@section('custom-fields-right')
    @include('adminpost::types.Asset.includes.form-right')
@endsection