<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route($route_prefix.'index',['type'=>request()->type]) }}" class="btn btn-danger px-4">{{ __('sys.back') }}</a>
            <button type="submit" class="btn btn-primary px-4">{{ __('sys.save') }}</button>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="mb-4">
            <label class="mb-3">Ảnh</label>
            <x-admintheme::form-image name="image" imageUrl="{{ $item->image ?? '' }}" upload="1" accept=".jpg, .png, image/jpeg, image/png"/>
            <x-admintheme::form-input-error field="image"/>
        </div>
        <div class="mb-4">
            <label class="mb-3">Tổ</label>
            <x-admintheme::form-nest model="{{$nest_model}}" nest_id="{{ is_object($item) ? $item->nest_id : old('nest_id') }}" />
            <x-admintheme::form-input-error field="nest_id"/>
        </div>
        <div class="mb-4">
            <label class="mb-3">Nhóm người dùng</label>
            <x-admintheme::form-group model="{{$group_model}}" nest_id="{{ is_object($item) ? $item->group_id : old('group_id') }}" />
            <x-admintheme::form-input-error field="group_id"/>
        </div>
    </div>
</div>

@yield('form-right')