@extends('admintheme::layouts.master')
@section('content')
@include('admintheme::includes.globals.breadcrumb',[
'page_title' => 'Tạo phiếu',
])

<div class="row">
    <div class="col-12 col-lg-12">
        <form id="borrow-form" action="{{ route('borrows.update',$item->id) }}" method="post">
            <input type="hidden" name="task" id="task">
            <input type="hidden" name="status" id="status" value="{{ $item->status }}">
            @csrf
            @method('PUT')
            @include('borrow::includes.form')
        </form>
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="{{ route($route_prefix.'index') }}" class="btn btn-sm btn-dark">Quay lại</a>
                    @if( $item->status < 0 )
                    <form action="{{ route($route_prefix.'destroy',$item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick=" return confirm('{{ __('sys.confirm_delete') }}') " class="btn btn-sm btn-danger px-4 mr-2">
                            {{ __('borrow::sys.delete') }} 
                        </button>
                    </form>
                    <button id="save_draft" class="btn btn-sm btn-warning px-4 mr-2"  >Lưu Nháp</button>
                    <button id="submit_request" class="btn btn-sm btn-primary px-4 ml-2" >Gửi Yêu Cầu</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!--end row-->

@endsection
@section('footer')
    @include('borrow::includes.modal-devices')
    @include('borrow::includes.modal-labs')
    <script src="{{ asset('admin-assets/js/repeater.js') }}"></script>
    <script>
        var tiet_id = 0;
        // device-table-results
        var indexUrl = "{{ route('borrows.index') }}";
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
            jQuery('body').on('click', "#save_draft", function(e) {
                jQuery('#borrow-form').find('#status').val('{{ $model::DRAFT }}');
                saveItem('save-form');
            });
            jQuery('body').on('click', "#submit_request", function(e) {
                jQuery('#borrow-form').find('#status').val('{{ $model::INACTIVE }}');
                saveItem('save-form');
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
                                if( task == 'save-form' ){
                                    window.location.href = indexUrl;
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