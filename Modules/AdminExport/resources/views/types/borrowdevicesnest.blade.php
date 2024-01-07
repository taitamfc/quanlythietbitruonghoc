@extends('adminexport::layouts.master')
@section('form-fields')
<div class="form-group mb-4">
    <label class="form-label fw-bold">Ngày dạy : Tuần</label>
    <input type="week" min="2022-W01" max="{{ date('Y') }}-W99" name="week" class="form-control"
        value="{{ request()->week }}" >
    <p class="mb-0">Nếu đã chọn Năm thì không chọn Tuần</p>
    <x-admintheme::form-input-error field="week" />
</div>
<div class="form-group mb-4">
    <label class="form-label fw-bold">Ngày dạy : Năm</label>
    <x-admintheme::form-input-school-years name="school_years" selected_id="{{ request()->school_years }}"/>
    <p class="mb-0">Nếu đã chọn Tuần thì không chọn Năm</p>
    <x-admintheme::form-input-error field="school_years" />
</div>
<div class="form-group mb-4">
    <label class="form-label fw-bold">Chọn Tổ</label>
    <x-admintheme::form-input-nests name="nest_id" selected_id="{{ request()->nest_id }}" />
    <p class="mb-0">Không chọn có nghĩa là xuất cho tất cả các tổ</p>
    <x-admintheme::form-input-error field="nest_id" />
</div>
@endsection