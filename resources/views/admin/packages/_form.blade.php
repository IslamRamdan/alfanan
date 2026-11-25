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
            <label>اسم الباقة (عربي) <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $package->name ?? '') }}"
                placeholder="مثال: باقة الهوية الذهبية" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>اسم الباقة (إنجليزي)</label>
            <input type="text" name="name_en" class="form-control"
                value="{{ old('name_en', $package->name_en ?? '') }}" placeholder="Golden Brand Identity Package">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>أيقونة الباقة (FontAwesome)</label>
            <input type="text" name="icon" class="form-control"
                value="{{ old('icon', $package->icon ?? 'fas fa-box-open') }}" placeholder="fas fa-rocket">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>السعر <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="price" class="form-control"
                value="{{ old('price', $package->price ?? '') }}" placeholder="1899" required>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>العملة <span class="text-danger">*</span></label>
            <input type="text" name="currency" class="form-control"
                value="{{ old('currency', $package->currency ?? 'ر.س') }}" required>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>الشارة (عربي)</label>
            <input type="text" name="badge" class="form-control" value="{{ old('badge', $package->badge ?? '') }}"
                placeholder="مثال: وفر 15% أو الأكثر طلبًا">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>الشارة (إنجليزي)</label>
            <input type="text" name="badge_en" class="form-control"
                value="{{ old('badge_en', $package->badge_en ?? '') }}" placeholder="Save 15% أو Most Popular">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label>الوصف المختصر (عربي)</label>
            <textarea name="description" rows="2" class="form-control" placeholder="وصف مختصر يظهر أسفل اسم الباقة">{{ old('description', $package->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-md-5">
        <div class="form-group">
            <label>الوصف المختصر (إنجليزي)</label>
            <textarea name="description_en" rows="2" class="form-control" placeholder="Short description under package name">{{ old('description_en', $package->description_en ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>ترتيب العرض</label>
            <input type="number" name="sort_order" class="form-control"
                value="{{ old('sort_order', $package->sort_order ?? 0) }}">
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1"
                {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_featured">تمييز الباقة (الأكثر طلبًا)</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_active">مفعّلة (ظاهرة في الموقع)</label>
        </div>
    </div>
</div>

<hr>

<div class="form-group">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="mb-0">مميزات الباقة <span class="text-danger">*</span></label>
        <button type="button" id="add-feature" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> إضافة ميزة
        </button>
    </div>

    <div id="features-wrapper">
        @php
            $featuresAr = old('features', $package->features ?? ['']);
            $featuresEn = old('features_en', $package->features_en ?? []);
            $count = max(count($featuresAr), 1);
        @endphp

        @for ($i = 0; $i < $count; $i++)
            <div class="row mb-2 feature-row align-items-center">
                <div class="col-md-6">
                    <input type="text" name="features[]" class="form-control"
                        value="{{ $featuresAr[$i] ?? '' }}" placeholder="ميزة الباقة (عربي)..." required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="features_en[]" class="form-control"
                        value="{{ $featuresEn[$i] ?? '' }}" placeholder="Package feature (English - اختياري)">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-feature">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endfor
    </div>
</div>
