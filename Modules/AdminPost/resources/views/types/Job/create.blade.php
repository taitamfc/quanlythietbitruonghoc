@extends('adminpost::create')

@section('custom-fields-left')
    @include('adminpost::types.Job.includes.form-left')
@endsection

@section('custom-fields-right')
    @include('adminpost::types.Job.includes.form-right')
@endsection