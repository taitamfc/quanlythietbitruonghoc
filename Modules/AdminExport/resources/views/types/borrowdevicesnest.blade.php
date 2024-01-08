@extends('adminexport::layouts.master')
@section('form-fields')
<div class="form-group mb-4">
    <label class="form-label fw-bold">Từ ngày : <span class="text-danger">(*)</span></label>
    <input type="date" name="start_date" class="form-control" value="{{ request()->start_date }}">
    <!-- <p class="mb-0">Nếu đã chọn Năm thì không chọn Tuần</p> -->
    <x-admintheme::form-input-error field="start_date" />
</div>
<div class="form-group mb-4">
    <label class="form-label fw-bold">Đến ngày : <span class="text-danger">(*)</span></label>
    <input type="date" name="end_date" class="form-control" value="{{ request()->end_date }}">
    <!-- <p class="mb-0">Nếu đã chọn Tuần thì không chọn Năm</p> -->
    <x-admintheme::form-input-error field="end_date" />
</div>
<div class="form-group mb-4">
    <label class="form-label fw-bold">Chọn Tổ</label>
    <x-admintheme::form-input-nests name="nest_id" selected_id="{{ request()->nest_id }}" />
    <p class="mb-0">Không chọn có nghĩa là xuất cho tất cả các tổ</p>
    <!-- <x-admintheme::form-input-error field="nest_id" /> -->
</div>
@endsection