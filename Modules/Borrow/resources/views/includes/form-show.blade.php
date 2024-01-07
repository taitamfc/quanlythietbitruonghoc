<div class="card">
    <div class="card-body">
        <div class="card-title fw-bold text-uppercase">Thông Tin Phiếu Mượn</div>
        <div class="my-3 border-top"></div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label" for="user_id">Người Mượn</label>
                    <p class="form-control-static fw-bold">{{ $item->user->name ?? '' }}</p>
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
                    <p class="form-control-static fw-bold">{{ date('d/m/Y',strtotime($item->borrow_date)) }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="repeater">
    @if( count( $item->borrow_items ) )
        @foreach( $item->borrow_items as $tiet =>  $borrow_items )
            @include('borrow::includes.borrow-item-show',[ 
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