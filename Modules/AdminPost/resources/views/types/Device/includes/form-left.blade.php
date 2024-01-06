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
                    <input type="number" class="form-control" name="quantity" value="{{ $item->quantity ?? old('quantity') }}">
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
                    <select name="device_type_id" class="form-control">
                        <option value="">---</option>
                        @foreach( \App\Models\DeviceType::getAll(true) as $device_type )
                            <option @selected($device_type->id == @$item->device_type_id) value="{{ $device_type->id }}">{{ $device_type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                <label class="mb-3">Bộ môn</label>
                    <select name="department_id" class="form-control">
                        <option value="">---</option>
                        @foreach( \App\Models\Department::getAll(true) as $department )
                            <option @selected($department->id == @$item->department_id) value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>