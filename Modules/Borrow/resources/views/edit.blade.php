@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Tạo phiếu',
])
<form id="borrow-form" action="{{ route('borrows.update',$item->id) }}" method="post">
    <input type="hidden" name="task" id="task">
    @method('PUT')
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
                            <div class="form-group input-borrow_date">
                                <label class="form-label" for="borrow_date">Ngày Dạy</label>
                                <input name="borrow_date" min="{{ date('Y-m-d') }}" type="date" class="form-control"
                                    placeholder="Nhập ngày dạy" value="{{ $item->borrow_date }}">
                                <span class="input-error text-danger"></span>
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
                            <button type="button" class="btn btn-sm btn-primary repeater-add-btn add-tiet px-4">Thêm Tiết Dạy</button>
                        </div>
                    </div>
                </div>

                @if( count( $item->borrow_items ) )
                    @foreach( $item->borrow_items as $tiet =>  $borrow_items )
                        @include('borrow::includes.borrow-item',[ 
                            'tiet' => $tiet,
                            'borrow_items' => $borrow_items,
                            'borrow' => $borrow_items[0],
                        ])
                    @endforeach
                @else
                    @include('borrow::includes.borrow-item',[ 
                        'tiet' => 0 , 
                        'borrow_items' => null,
                        'borrow' => null,
                    ])
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <form action="{{ route($route_prefix.'destroy',$item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button onclick=" return confirm('{{ __('sys.confirm_delete') }}') " class="btn btn-sm btn-danger px-4 mr-2">
                                {{ __('borrow::sys.delete') }} 
                            </button>
                        </form>
                        <button class="btn btn-sm btn-warning px-4 mr-2">Lưu Nháp</button>
                        <button class="btn btn-sm btn-primary px-4 ml-2">Gửi Yêu Cầu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end row-->

@endsection
@section('footer')
@include('borrow::includes.modal-devices')
@include('borrow::includes.modal-labs')
<script src="{{ asset('admin-assets/js/repeater.js') }}"></script>
<script>
    var tiet_id = 0;
    // device-table-results
    var indexUrl = "{{ route('website.devices.index') }}";
    var positionUrl = "";
    var params = <?= json_encode(request()->query()); ?>;
    var wrapperResults = '.device-table-results';
    var actionUrl = jQuery('#borrow-form').attr('action');
    jQuery(document).ready(function() {
        //$("#repeater").createRepeater({
          //  showFirstItemToDefault: true,
           // isFirstItemUndeletable: true,
            //initEmpty:false
        //});
        // Handle show devices
        jQuery('body').on('click', ".show-devices", function(e) {
            tiet_id = jQuery(this).data('tiet-id');
            saveItem('show-devices');
        });
        jQuery('body').on('click', ".show-labs", function(e) {
            tiet_id = jQuery(this).data('tiet-id');
            saveItem('show-labs');
        });
        jQuery('body').on('click', ".add-tiet", function(e) {
            saveItem('add-tiet');
        });
        jQuery('body').on('click', ".delete-tiet", function(e) {
            let ask = confirm('Bạn có chắc chắn xóa tiết dạy này không ?')
            if( ask == true ){
                tiet_id = jQuery(this).data('tiet-id');
                jQuery(this).closest('.items').remove();
                saveItem('delete-tiet');
            }

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
                        <input name="devices[${tiet_id}][quantity]" type="number" min="1" value="1" class="form-control">
                    </td>
                    <td>${device_type_name}</td>
                    <td>${department_name}</td>
                    <td>
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </td>
                </tr>
            `;
            jQuery('.items[data-tiet="'+tiet_id+'"]').find('.tiet_devices').append(device_html);
            saveItem();
        });

        function saveItem(task = 'show-devices'){
            jQuery('#task').val(task);
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: actionUrl,
                type: "POST",
                dataType:'json',
                data: jQuery('#borrow-form').serialize(),
                success: function (res) {
                    if (res.has_errors) {
                        for (const key in res.errors) {
                            let keyClass = key.replaceAll('.','-');
                            jQuery('.input-' + keyClass).find('.input-error').html(res.errors[key][0]);
                        }
                        showAlertError('Vui lòng điền vào các trường bắt buộc !')
                    }else{
                        if (res.success == true) {
                            showAlertSuccess(res.msg)
                            if(task == 'show-devices'){
                                jQuery('#modal-devices').modal('show');
                            }
                            if(task == 'add-tiet' || task == 'delete-tiet'){
                                window.location.reload();
                            }
                            if(task == 'show-labs'){
                                jQuery('#modal-labs').modal('show');
                            }
                        }else{
                            showAlertError(res.msg)
                        }
                    }
                }
            });
        }

    });
</script>
@endsection