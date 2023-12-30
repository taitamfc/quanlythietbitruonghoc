<div class="card">
    <div class="card-body">
        <div class="mb-4">
            <label class="mb-3">{{ __('admintaxonomy::form.name') }}</label>
            <input type="text" class="form-control" name="name" value="{{ $item->name ?? old('name') }}">
            <x-admintheme::form-input-error field="name"/>
        </div>
        <div class="mb-4">
            <label class="mb-3">{{ __('admintaxonomy::form.description') }}</label>
            <textarea class="form-control" name="description" cols="4" rows="6">{{ $item->description ?? old('description') }}</textarea>
            <x-admintheme::form-input-error field="description"/>
        </div>
    </div>
</div>

@yield('form-left')