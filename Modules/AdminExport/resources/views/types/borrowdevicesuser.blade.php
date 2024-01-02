@extends('adminexport::layouts.master')
@section('form-fields')
    <div class="form-group mb-4">
        <label class="form-label fw-bold">Ngày dạy : Tuần</label>
        <input type="week" min="2022-W01" max="{{ date('Y') }}-W99" name="week" class="form-control" value="{{ request()->week }}" onchange="this.form.submit()">
        <p class="mb-0">Nếu đã chọn Năm thì không chọn Tuần</p>
    </div>
    <div class="form-group mb-4">
        <label class="form-label fw-bold">Ngày dạy : Năm</label>
        <x-admintheme::form-input-school-years name="school_years" selected_id="{{ request()->school_years }}" autoSubmit="true"/>
        <p class="mb-0">Nếu đã chọn Tuần thì không chọn Năm</p>
    </div>
    <div class="form-group mb-4">
        <label class="form-label fw-bold">Giáo Viên <span class="text-danger">(*)</span></label>
        <x-admintheme::form-input-users name="user_id" selected_id="{{ request()->user_id }}" autoSubmit="true"/>
        <x-admintheme::form-input-error field="user_id"/>
    </div>
@endsection