@if($upload)
<input class="form-control" name="{{ $name }}" type="file" accept="{{ $accept }}">
@endif
@if($imageUrl)
<div class="card mt-2">
    <img src="{{ $imageUrl }}" class="card-img">
</div>
@endif