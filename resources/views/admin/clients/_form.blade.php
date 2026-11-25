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
    <div class="col-md-4">
        <div class="form-group">
            <label>اسم العميل <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $client->name ?? '') }}"
                required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>صورة العميل @if (!isset($client))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" name="logo" class="form-control-file" accept="image/*"
                {{ isset($client) ? '' : 'required' }}>
            @if (isset($client) && $client->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}"
                        style="max-height: 75px; object-fit: contain; border-radius: 6px;">
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>ترتيب العرض</label>
            <input type="number" name="sort_order" class="form-control"
                value="{{ old('sort_order', $client->sort_order ?? 0) }}">
        </div>
    </div>

    <div class="col-md-2 d-flex align-items-center">
        <div class="custom-control custom-switch mt-3">
            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_active">مفعّل</label>
        </div>
    </div>
</div>
