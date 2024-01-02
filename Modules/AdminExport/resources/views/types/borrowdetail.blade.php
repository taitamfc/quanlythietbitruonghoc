@extends('adminexport::layouts.master')
@section('form-fields')
    <div class="form-group mb-4">
        <label class="form-label">Mã Phiếu Mượn <span class="text-danger">(*)</span></label>
        <input type="number" name="id" class="form-control">
        <x-admintheme::form-input-error field="id"/>
    </div>
@endsection