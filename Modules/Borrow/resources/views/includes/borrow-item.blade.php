<?php
    $borrow = $borrow ? $borrow->toArray() : [
        'lesson_name' => '',
        'session' => '',
        'lecture_name' => '',
        'room_id' => '',
        'lecture_number' => '',
    ];
    $borrow_items = $borrow_items ? $borrow_items : [];
?>
<div class="items" data-group="devices" data-tiet="{{ $tiet }}">
    <input type="hidden" data-name="tiet" name="devices[{{ $tiet }}][tiet]" name="devices[{{ $tiet }}][tiet]" value="{{ $tiet }}">
    <div class="card">
        <div class="card-body">
            <!-- Repeater Content 
            Tên bài dạy	Buổi	Tiêt PPCT	Lớp	Tiết TKB
            -->
            <div class="item-content">
                <div class="row mb-4">
                    <div class="col col-lg-2 col-6 input-devices-{{ $tiet }}-lesson_name">
                        <label class="form-label">Tên bài dạy</label>
                        <input type="text" class="form-control" id="devices_{{ $tiet }}_lesson_name"
                            data-name="lesson_name" name="devices[{{ $tiet }}][lesson_name]" value="{{ $borrow['lesson_name'] }}">
                        <span class="input-error text-danger"></span>
                    </div>
                    <div class="col col-lg-2 col-6">
                        <label class="form-label">Buổi</label>
                        <select data-name="session" name="devices[{{ $tiet }}][session]" id="devices_{{ $tiet }}_session"
                            class="form-control">
                            <option @selected($borrow['session'] == 'Sáng') value="Sáng">Sáng</option>
                            <option @selected($borrow['session'] == 'Chiều') value="Chiều">Chiều</option>
                        </select>
                    </div>
                    <div class="col col-lg-2 col-6 input-devices-{{ $tiet }}-lecture_name">
                        <label class="form-label">Tiết PPCT</label>
                        <input type="text" class="form-control" id="devices_{{ $tiet }}_lecture_name"
                            data-name="lecture_name" name="devices[{{ $tiet }}][lecture_name]" value="{{ $borrow['lecture_name'] }}">
                            <span class="input-error text-danger"></span>
                    </div>
                    <div class="col col-lg-2 col-6">
                        <label class="form-label">Lớp</label>
                        <select data-name="room_id"  name="devices[{{ $tiet }}][room_id]" id="devices_{{ $tiet }}_room_id"
                            class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="col col-lg-1 col-6">
                        <label class="form-label">Tiết TKB</label>
                        <select data-name="lecture_number" data-name="devices[{{ $tiet }}][lecture_number]" name="devices[{{ $tiet }}][lecture_number]"
                            id="devices_{{ $tiet }}_lecture_number" class="form-control">
                            <option @selected($borrow['session'] == 1) value="1">1</option>
                            <option @selected($borrow['session'] == 2) value="2">2</option>
                            <option @selected($borrow['session'] == 3) value="3">3</option>
                            <option @selected($borrow['session'] == 4) value="4">4</option>
                            <option @selected($borrow['session'] == 5) value="5">5</option>
                        </select>
                    </div>
                    <div class="col col-lg-3 col-6">
                        <div><label class="form-label">Phòng bộ môn</label></div>
                        <input data-name="lab_id" name="devices[{{ $tiet }}][lab_id]" id="devices_{{ $tiet }}_lab_id" type="hidden">
                        <button class="btn btn-sm btn-info px-4 mt-1">Chọn</button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="fw-bold" for="">DANH SÁCH THIẾT BỊ TRONG TIẾT NÀY</label>
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-primary show-devices" data-tiet-id="{{ $tiet }}">Thêm Thiết Bị</button>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="table-responsive white-space-nowrap">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th width="300px">Tên thiết bị</th>
                                        <th>Số lượng</th>
                                        <th>Loại thiết bị</th>
                                        <th>Bộ môn</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="tiet_devices">
                                    @foreach($borrow_items as $key => $borrow_item)
                                    <tr class="device_item">
                                        <td>{{ $key + 1 }}<input data-name="device_id" name="devices[0][device_id]" type="hidden" value="{{ $borrow_item->device_id }}"></td>
                                        <td>{{ $borrow_item->device->name }}</td>
                                        <td width="100px">
                                            <input data-name="quantity" name="devices[0][quantity]" type="number" min="1" value="{{ $borrow_item->quantity }}" class="form-control">
                                        </td>
                                        <td>{{ $borrow_item->device->devicetype->name }}</td>
                                        <td>{{ $borrow_item->device->department->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger">Xóa</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Repeater Remove Btn -->
            <div class="repeater-remove-btn">
                <button class="btn btn-danger btn-sm remove-btn px-4">
                    Xóa tiết dạy này
                </button>
            </div>
        </div>
    </div>
</div>