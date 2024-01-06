<div class="card">
    <div class="card-body">
        <div class="mb-4">
            <label class="mb-3">{{ __('admintaxonomy::form.status') }}</label>
            <x-admintheme::form-status model="{{ $model }}" status="{{ $item->status ?? old('status') }}"/>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admintaxonomy.index',['type'=>request()->type]) }}" class="btn btn-danger px-4">{{ __('sys.back') }}</a>
            <button type="submit" class="btn btn-primary px-4">{{ __('sys.save') }}</button>
        </div>
    </div>
</div>

@yield('custom-fields-right')