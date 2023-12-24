@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Tạo phiếu',
])
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title fw-bold text-uppercase">Thông Tin Phiếu Mượn</div>
                <div class="my-3 border-top"></div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label" for="user_id">Người Mượn</label>
                            <p class="form-control-static fw-bold">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label" for="created_at">Ngày Tạo Phiếu</label>
                            <p class="form-control-static fw-bold">{{ date('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label" for="borrow_date">Ngày Dạy</label>
                            <input name="borrow_date" min="{{ date('Y-m-d') }}" type="date" class="form-control"
                                placeholder="Nhập ngày dạy" value="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="repeater">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">Giáo viên có thể thêm nhiều tiết dạy, mỗi tiết dạy không yêu cầu thêm thiết bị.</p>
                        <button class="btn btn-sm btn-primary repeater-add-btn px-4">Thêm Tiết Dạy</button>
                    </div>
                </div>
            </div>

            <div class="items" data-group="devices" data-tiet="1">
                <div class="card">
                    <div class="card-body">
                        <!-- Repeater Content 
                        Tên bài dạy	Buổi	Tiêt PPCT	Lớp	Tiết TKB
                        -->
                        <div class="item-content">
                            <div class="row mb-4">
                                <div class="col col-lg-2 col-6">
                                    <label class="form-label">Tên bài dạy</label>
                                    <input type="text" class="form-control" id="devices_0_lesson_name"
                                        data-name="lesson_name" name="devices[0][lesson_name]" value="">
                                </div>
                                <div class="col col-lg-2 col-6">
                                    <label class="form-label">Buổi</label>
                                    <select data-name="session" name="devices[0][session]" id="devices_0_session"
                                        class="form-control">
                                        <option value="Sáng">Sáng</option>
                                        <option value="Chiều">Chiều</option>
                                    </select>
                                </div>
                                <div class="col col-lg-2 col-6">
                                    <label class="form-label">Tiết PPCT</label>
                                    <input type="text" class="form-control" id="devices_0_lecture_name"
                                        data-name="lecture_name" name="devices[0][lecture_name]" value="">
                                </div>
                                <div class="col col-lg-2 col-6">
                                    <label class="form-label">Lớp</label>
                                    <select data-name="room_id" name="devices[0][room_id]" id="devices_0_room_id"
                                        class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                                <div class="col col-lg-1 col-6">
                                    <label class="form-label">Tiết TKB</label>
                                    <select data-name="lecture_number" name="devices[0][lecture_number]"
                                        id="devices_0_lecture_number" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="col col-lg-3 col-6">
                                    <div><label class="form-label">Phòng bộ môn</label></div>
                                    <input data-name="lab_id" name="devices[0][lab_id]" id="devices_0_lab_id" type="hidden">
                                    <button class="btn btn-sm btn-info px-4 mt-1">Chọn</button>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="fw-bold" for="">DANH SÁCH THIẾT BỊ TRONG TIẾT NÀY</label>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-primary show-devices" data-tiet-id="1">Thêm Thiết Bị</button>
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

            

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <button class="btn btn-sm btn-danger px-4 mr-2">Hủy Phiếu</button>
                        <button class="btn btn-sm btn-warning px-4 mr-2">Lưu Nháp</button>
                        <button class="btn btn-sm btn-primary px-4 ml-2">Gửi Yêu Cầu</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--end row-->
@include('borrow::includes.modal-devices')
@endsection
@section('footer')
<script src="{{ asset('admin-assets/js/app.js') }}"></script>
<script>
    var tiet_id = 0;
    // device-table-results
    var indexUrl = "{{ route('website.devices.index') }}";
    var positionUrl = "";
    var params = <?= json_encode(request()->query()); ?>;
    var wrapperResults = '.device-table-results';
    jQuery(document).ready(function() {
        // Get all items
        getAjaxTable(indexUrl, wrapperResults, positionUrl, 'limit=20');
        // Handle pagination
        jQuery('body').on('click', ".page-link", function(e) {
            e.preventDefault();
            let url = jQuery(this).attr('href');
            getAjaxTable(url, wrapperResults, positionUrl);
        });
        jQuery('body').on('change', '.f-filter', function() {
            let filterData = jQuery('#form-search').serialize();
            getAjaxTable(indexUrl, wrapperResults, positionUrl, filterData);
        });
        jQuery('body').on('keyup', '.f-filter-up',delay(function (e) {
            let filterData = jQuery('#form-search').serialize();
            getAjaxTable(indexUrl, wrapperResults, positionUrl, filterData);
        }, 500));

        // Handle show devices
        jQuery('body').on('click', ".show-devices", function(e) {
            tiet_id = jQuery(this).data('tiet-id');
            jQuery('#modal-devices').modal('show');
        });

        // Handle add device
        jQuery('body').on('click', ".add-device", function(e) {
            let device_id = jQuery(this).data('device-id');
            let device_name = jQuery(this).closest('tr').data('name');
            let device_type_name = jQuery(this).closest('tr').data('device_type_name');
            let department_name = jQuery(this).closest('tr').data('department_name');
            let device_html = `
                <tr class="device_item">
                    <td><input name="devices[${tiet_id}][device_id]" type="hidden" value="${device_id}"></td>
                    <td>${device_name}</td>
                    <td width="100px">
                        <input name="devices[${tiet_id}][qty]" type="number" min="1" value="1" class="form-control">
                    </td>
                    <td>${device_type_name}</td>
                    <td>${department_name}</td>
                    <td>
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </td>
                </tr>
            `;
            jQuery('.items[data-tiet="'+tiet_id+'"]').find('.tiet_devices').append(device_html);
        });

    });
</script>
@endsection