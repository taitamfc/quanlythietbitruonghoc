@extends('lab::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('lab.name') !!}</p>
@endsection
