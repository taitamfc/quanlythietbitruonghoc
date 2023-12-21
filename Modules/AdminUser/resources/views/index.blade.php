@extends('adminuser::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('adminuser.name') !!}</p>
@endsection
