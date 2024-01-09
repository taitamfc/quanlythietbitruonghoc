<div class="card">
    <div class="card-header">
        <div class="text-uppercase fw-bold">Thông tin thiết bị</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Nước sản xuât</label>
                    <input type="text" class="form-control" name="country_name" value="{{ $item->country_name ?? old('country_name') }}">
                    <x-admintheme::form-input-error field="country_name"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Năm sản xuât</label>
                    <input type="number" class="form-control" name="year" value="{{ $item->year ?? old('year') }}">
                    <x-admintheme::form-input-error field="year"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Số lượng</label>
                    <input type="number" class="form-control" min="0" name="quantity" value="{{ $item->quantity ?? old('quantity',0) }}">
                    <x-admintheme::form-input-error field="quantity"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Đơn vị</label>
                    <input type="text" class="form-control" name="unit" value="{{ $item->unit ?? old('unit') }}">
                    <x-admintheme::form-input-error field="unit"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Giá tiền</label>
                    <input type="number" class="form-control" name="price" value="{{ $item->price ?? old('price') }}">
                    <x-admintheme::form-input-error field="price"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Ghi chú</label>
                    <input type="number" class="form-control" name="note" value="{{ $item->note ?? old('note') }}">
                    <x-admintheme::form-input-error field="note"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="mb-3">Loại Thiết Bị</label>
                    <x-admintheme::form-input-device-types name="device_type_id" selected_id="{{ old('device_type_id',$item->device_type_id) }}"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                <label class="mb-3">Bộ môn</label>
                    <x-admintheme::form-input-departments name="department_id" selected_id="{{ old('department_id',$item->department_id) }}" />
                </div>
            </div>
        </div>
    </div>
</div>