@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label>صورة السلايد @if (!isset($slide))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" name="image" class="form-control-file" accept="image/*"
                {{ isset($slide) ? '' : 'required' }}>
            @if (isset($slide) && $slide->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $slide->image) }}" alt="preview"
                        style="max-height: 120px; border-radius: 6px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>عنوان توضيحي (للإدارة فقط)</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $slide->title ?? '') }}"
                placeholder="مثال: بانر الطباعة">
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>ترتيب العرض</label>
            <input type="number" name="sort_order" class="form-control"
                value="{{ old('sort_order', $slide->sort_order ?? 0) }}">
        </div>
    </div>

    <div class="col-md-2 d-flex align-items-center">
        <div class="custom-control custom-switch mt-3">
            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_active">مفعّل</label>
        </div>
    </div>
</div>
