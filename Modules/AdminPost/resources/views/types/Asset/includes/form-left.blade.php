<div class="card">
    <div class="card-header">
        <div class="text-uppercase fw-bold">Thông tin công việc</div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <label class="mb-3">{{ __('adminpost::form.name') }}</label>
            <input type="text" class="form-control" name="name" value="{{ $item->name ?? old('name') }}">
            <x-admintheme::form-input-error field="name"/>
        </div>
    </div>
</div>