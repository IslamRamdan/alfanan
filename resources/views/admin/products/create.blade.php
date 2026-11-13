@extends('adminlte::page')

@section('title', 'إضافة منتج جديد')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">إضافة منتج جديد</h1>
            <small class="text-muted">أدخل بيانات المنتج بالعربية والإنجليزية وارفع صوره، ثم اضغط «حفظ المنتج».</small>
        </div>
        <ol class="breadcrumb float-sm-left mb-0 bg-transparent">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
            <li class="breadcrumb-item active">إضافة منتج</li>
        </ol>
    </div>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .product-form {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            --pf-primary: #0d6efd;
            --pf-primary-soft: #eaf2ff;
            --pf-border: #d9dee7;
            --pf-muted: #6b7686;
            --pf-danger: #dc3545;
            --pf-radius: 10px;
        }

        .product-form .card {
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            box-shadow: none;
            margin-bottom: 1.25rem;
        }

        .product-form .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pf-border);
            border-radius: var(--pf-radius) var(--pf-radius) 0 0;
            padding: .9rem 1.25rem;
        }

        .product-form .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .product-form .card-header .hint {
            color: var(--pf-muted);
            font-size: .85rem;
            margin-top: .15rem;
        }

        .product-form .card-body {
            padding: 1.25rem;
        }

        .product-form label.field-label {
            font-weight: 600;
            margin-bottom: .35rem;
        }

        .product-form .req {
            color: var(--pf-danger);
            margin-right: .2rem;
        }

        .product-form .form-control {
            border-radius: 8px;
            border-color: var(--pf-border);
            min-height: 42px;
        }

        .product-form .form-control:focus {
            border-color: var(--pf-primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        .product-form .field-error {
            color: var(--pf-danger);
            font-size: .85rem;
            margin-top: .3rem;
            display: block;
        }

        /* ---------- Drop zones ---------- */
        .drop-input {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        .drop-zone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            text-align: center;
            padding: 1.75rem 1rem;
            border: 2px dashed var(--pf-border);
            border-radius: var(--pf-radius);
            background: #f8fafc;
            color: var(--pf-muted);
            cursor: pointer;
            transition: border-color .15s, background-color .15s;
            margin: 0;
        }

        .drop-zone i {
            font-size: 1.9rem;
            color: var(--pf-primary);
        }

        .drop-zone strong {
            color: #1f2a37;
        }

        .drop-zone:hover,
        .drop-zone.is-over,
        .drop-input:focus+.drop-zone {
            border-color: var(--pf-primary);
            background: var(--pf-primary-soft);
        }

        .drop-zone.has-error {
            border-color: var(--pf-danger);
        }

        /* ---------- Main image preview ---------- */
        .main-preview {
            display: none;
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            overflow: hidden;
            background: #fff;
        }

        .main-preview.show {
            display: block;
        }

        .main-preview .frame {
            aspect-ratio: 1 / 1;
            background: #f1f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .main-preview .meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            padding: .6rem .75rem;
            border-top: 1px solid var(--pf-border);
            font-size: .85rem;
        }

        .main-preview .meta .name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            direction: ltr;
            text-align: right;
            flex: 1;
        }

        .main-preview .meta .size {
            color: var(--pf-muted);
            white-space: nowrap;
        }

        /* ---------- Gallery ---------- */
        .gallery-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1rem 0 .6rem;
            font-size: .9rem;
        }

        .gallery-count {
            background: var(--pf-primary-soft);
            color: var(--pf-primary);
            font-weight: 600;
            border-radius: 20px;
            padding: .1rem .7rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(88px, 1fr));
            gap: .6rem;
        }

        .gallery-item {
            position: relative;
            aspect-ratio: 1 / 1;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--pf-border);
            background: #f1f4f8;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-item .remove {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 24px;
            height: 24px;
            border: 0;
            border-radius: 50%;
            background: rgba(17, 24, 39, .75);
            color: #fff;
            font-size: .75rem;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .gallery-item .remove:hover,
        .gallery-item .remove:focus {
            background: var(--pf-danger);
        }

        .gallery-empty {
            grid-column: 1 / -1;
            text-align: center;
            color: var(--pf-muted);
            font-size: .88rem;
            padding: 1rem .5rem;
            border: 1px dashed var(--pf-border);
            border-radius: 8px;
        }

        /* ---------- Specs ---------- */
        .spec-row {
            display: flex;
            gap: .6rem;
            align-items: flex-start;
            margin-bottom: .6rem;
        }

        .spec-row .form-control {
            flex: 1;
        }

        .spec-row .btn-remove-spec {
            flex: 0 0 42px;
            height: 42px;
            border-radius: 8px;
            border: 1px solid var(--pf-border);
            background: #fff;
            color: var(--pf-danger);
        }

        .spec-row .btn-remove-spec:hover {
            background: #fdecee;
        }

        @media (max-width: 575.98px) {
            .spec-row {
                flex-wrap: wrap;
            }

            .spec-row .form-control {
                flex: 1 1 100%;
            }
        }

        /* ---------- Sticky action bar ---------- */
        .action-bar {
            position: sticky;
            bottom: 0;
            z-index: 5;
            display: flex;
            gap: .6rem;
            justify-content: flex-start;
            padding: .9rem 1.25rem;
            background: rgba(255, 255, 255, .96);
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            backdrop-filter: blur(4px);
        }

        .action-bar .btn {
            min-width: 130px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    @php
        $galleryErrors = collect($errors->get('images'))->merge(collect($errors->get('images.*'))->flatten());

        $oldSpecs = collect(old('specs', []))
            ->filter(
                fn($s) => filled($s['key_ar'] ?? null) ||
                    filled($s['key_en'] ?? null) ||
                    filled($s['value_ar'] ?? null) ||
                    filled($s['value_en'] ?? null),
            )
            ->values()
            ->all();

        if (empty($oldSpecs)) {
            $oldSpecs = [['key_ar' => '', 'key_en' => '', 'value_ar' => '', 'value_en' => '']];
        }
    @endphp

    <div class="product-form" dir="rtl">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>تعذّر حفظ المنتج. راجع الأخطاء التالية:</strong>
                <ul class="mb-0 mt-2 pr-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="mt-2 small">الصور لا يتم الاحتفاظ بها بعد الخطأ، أعد اختيارها قبل الحفظ.</div>
            </div>
        @endif

        <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
            novalidate>
            @csrf

            <div class="row">
                {{-- ================= العمود الرئيسي ================= --}}
                <div class="col-lg-8">

                    <!-- معلومات المنتج الأساسية بالعربية والإنجليزية -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">بيانات المنتج (الاسم والوصف)</h3>
                            <div class="hint">إدخال البيانات بالعربية والإنجليزية.</div>
                        </div>
                        <div class="card-body">

                            <!-- اسم المنتج (عربي) -->
                            <div class="form-group">
                                <label class="field-label" for="name_ar">اسم المنتج (بالعربية)<span
                                        class="req">*</span></label>
                                <input type="text" name="name_ar" id="name_ar"
                                    class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar') }}"
                                    placeholder="مثال: حذاء رياضي رجالي" required>
                                @error('name_ar')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- اسم المنتج (إنجليزي) -->
                            <div class="form-group" dir="ltr">
                                <label class="field-label float-right" for="name_en">Product Name (English)<span
                                        class="req">*</span></label>
                                <input type="text" name="name_en" id="name_en"
                                    class="form-control text-left @error('name_en') is-invalid @enderror"
                                    value="{{ old('name_en') }}" placeholder="Example: Men Sport Shoes" required>
                                @error('name_en')
                                    <span class="field-error text-right">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="field-label" for="sub_category_id">القسم الفرعي</label>
                                        <select name="sub_category_id" id="sub_category_id"
                                            class="form-control @error('sub_category_id') is-invalid @enderror">
                                            <option value="">-- اختر القسم الفرعي --</option>
                                            @foreach ($subCategories as $subCat)
                                                <option value="{{ $subCat->id }}"
                                                    {{ old('sub_category_id') == $subCat->id ? 'selected' : '' }}>
                                                    {{ $subCat->category->name_ar ?? ($subCat->category->name ?? 'قسم رئيسي') }}
                                                    &larr; {{ $subCat->name_ar ?? $subCat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="field-label" for="price">السعر (ر.س)<span
                                                class="req">*</span></label>
                                        <input type="number" step="0.01" min="0" name="price" id="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}" placeholder="0.00" required>
                                        @error('price')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- وصف المنتج بالعربية -->
                            <div class="form-group">
                                <label class="field-label" for="description_ar">وصف المنتج (بالعربية)</label>
                                <textarea name="description_ar" id="description_ar" rows="4"
                                    class="form-control @error('description_ar') is-invalid @enderror" placeholder="اكتب وصفًا واضحًا للمنتج بالعربية">{{ old('description_ar') }}</textarea>
                                @error('description_ar')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- وصف المنتج بالإنجليزية -->
                            <div class="form-group mb-0" dir="ltr">
                                <label class="field-label float-right" for="description_en">Product Description
                                    (English)</label>
                                <textarea name="description_en" id="description_en" rows="4"
                                    class="form-control text-left @error('description_en') is-invalid @enderror"
                                    placeholder="Write a clear product description in English">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <span class="field-error text-right">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- مواصفات المنتج -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="card-title">مواصفات المنتج (عربي / إنجليزي)</h3>
                                <div class="hint">اختيارية، حتى 5 مواصفات (اسم وقيمة باللغتين).</div>
                            </div>
                            <span class="gallery-count" id="specCounter">0 / 5</span>
                        </div>
                        <div class="card-body">
                            <div id="specsList">
                                @foreach ($oldSpecs as $i => $spec)
                                    <div class="spec-row">
                                        <input type="text" name="specs[{{ $i }}][key_ar]"
                                            class="form-control" value="{{ $spec['key_ar'] ?? '' }}"
                                            placeholder="اسم المواصفة (عربي)">
                                        <input type="text" name="specs[{{ $i }}][key_en]"
                                            class="form-control" value="{{ $spec['key_en'] ?? '' }}"
                                            placeholder="Spec Key (English)" dir="ltr">
                                        <input type="text" name="specs[{{ $i }}][value_ar]"
                                            class="form-control" value="{{ $spec['value_ar'] ?? '' }}"
                                            placeholder="القيمة (عربي)">
                                        <input type="text" name="specs[{{ $i }}][value_en]"
                                            class="form-control" value="{{ $spec['value_en'] ?? '' }}"
                                            placeholder="Value (English)" dir="ltr">
                                        <button type="button" class="btn-remove-spec" title="حذف المواصفة"
                                            aria-label="حذف المواصفة"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="addSpec" class="btn btn-outline-primary btn-sm mt-1">
                                <i class="fas fa-plus ml-1"></i> إضافة مواصفة
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ================= عمود الصور ================= --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">صور المنتج</h3>
                            <div class="hint">اسحب الصور هنا أو اضغط للاختيار.</div>
                        </div>
                        <div class="card-body">

                            {{-- الصورة الأساسية --}}
                            <label class="field-label d-block">الصورة الأساسية<span class="req">*</span></label>

                            <div style="position:relative">
                                <input type="file" name="image" id="image" class="drop-input" accept="image/*"
                                    required>
                                <label for="image" id="mainZone"
                                    class="drop-zone @error('image') has-error @enderror">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span><strong>اختر الصورة الأساسية</strong></span>
                                    <small>أو اسحبها وأفلتها هنا</small>
                                </label>
                            </div>

                            <div class="main-preview" id="mainPreview">
                                <div class="frame"><img id="mainImg" alt="معاينة الصورة الأساسية"></div>
                                <div class="meta">
                                    <span class="name" id="mainName"></span>
                                    <span class="size" id="mainSize"></span>
                                    <label for="image" class="btn btn-sm btn-outline-primary mb-0">تغيير</label>
                                    <button type="button" id="mainRemove"
                                        class="btn btn-sm btn-outline-danger">حذف</button>
                                </div>
                            </div>
                            @error('image')
                                <span class="field-error">{{ $message }}</span>
                            @enderror

                            <hr class="my-4">

                            {{-- الصور الفرعية --}}
                            <label class="field-label d-block">الصور الفرعية</label>

                            <div style="position:relative">
                                <input type="file" name="images[]" id="images" class="drop-input"
                                    accept="image/*" multiple>
                                <label for="images" id="galleryZone"
                                    class="drop-zone @if ($galleryErrors->isNotEmpty()) has-error @endif">
                                    <i class="far fa-images"></i>
                                    <span><strong>أضف صورًا فرعية</strong></span>
                                    <small>يمكنك اختيار أكثر من صورة وإضافة المزيد لاحقًا</small>
                                </label>
                            </div>
                            @foreach ($galleryErrors as $message)
                                <span class="field-error">{{ $message }}</span>
                            @endforeach

                            <div class="gallery-head">
                                <span>الصور المختارة</span>
                                <span>
                                    <span class="gallery-count" id="galleryCount">0</span>
                                    <button type="button" id="galleryClear"
                                        class="btn btn-link btn-sm text-danger p-0 mr-2" style="display:none">مسح
                                        الكل</button>
                                </span>
                            </div>
                            <div class="gallery-grid" id="galleryGrid"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-bar">
                <button type="submit" id="submitBtn" class="btn btn-primary">
                    <i class="fas fa-save ml-1"></i> حفظ المنتج
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-default">إلغاء</a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        (function() {
            const $ = (id) => document.getElementById(id);
            const formatSize = (b) => b >= 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(b /
                1024)) + ' KB';
            const isImage = (f) => f && f.type && f.type.startsWith('image/');

            function bindDrop(zone, onFiles) {
                ['dragenter', 'dragover'].forEach(ev => zone.addEventListener(ev, e => {
                    e.preventDefault();
                    zone.classList.add('is-over');
                }));
                ['dragleave', 'drop'].forEach(ev => zone.addEventListener(ev, e => {
                    e.preventDefault();
                    zone.classList.remove('is-over');
                }));
                zone.addEventListener('drop', e => onFiles(e.dataTransfer.files));
            }

            /* ================= الصورة الأساسية ================= */
            const mainInput = $('image'),
                mainZone = $('mainZone'),
                mainPreview = $('mainPreview'),
                mainImg = $('mainImg');
            let mainUrl = null;

            function showMain(file) {
                if (mainUrl) URL.revokeObjectURL(mainUrl);
                if (!file) {
                    mainUrl = null;
                    mainImg.removeAttribute('src');
                    mainPreview.classList.remove('show');
                    mainZone.style.display = '';
                    return;
                }
                mainUrl = URL.createObjectURL(file);
                mainImg.src = mainUrl;
                $('mainName').textContent = file.name;
                $('mainSize').textContent = formatSize(file.size);
                mainPreview.classList.add('show');
                mainZone.style.display = 'none';
            }

            mainInput.addEventListener('change', () => {
                const f = mainInput.files[0];
                if (f && !isImage(f)) {
                    mainInput.value = '';
                    return showMain(null);
                }
                showMain(f);
            });

            $('mainRemove').addEventListener('click', () => {
                mainInput.value = '';
                showMain(null);
            });

            bindDrop(mainZone, (list) => {
                const f = [...list].find(isImage);
                if (!f) return;
                const dt = new DataTransfer();
                dt.items.add(f);
                mainInput.files = dt.files;
                showMain(f);
            });

            /* ================= الصور الفرعية ================= */
            const galleryInput = $('images'),
                grid = $('galleryGrid');
            let gallery = []; // [{file, url}]

            function syncGallery() {
                const dt = new DataTransfer();
                gallery.forEach(g => dt.items.add(g.file));
                galleryInput.files = dt.files;
                renderGallery();
            }

            function addGalleryFiles(list) {
                [...list].filter(isImage).forEach(file => {
                    const exists = gallery.some(g => g.file.name === file.name && g.file.size === file.size &&
                        g.file.lastModified === file.lastModified);
                    if (!exists) gallery.push({
                        file,
                        url: URL.createObjectURL(file)
                    });
                });
                syncGallery();
            }

            function renderGallery() {
                grid.innerHTML = '';
                $('galleryCount').textContent = gallery.length;
                $('galleryClear').style.display = gallery.length ? '' : 'none';

                if (!gallery.length) {
                    grid.innerHTML = '<div class="gallery-empty">لم يتم اختيار صور فرعية بعد.</div>';
                    return;
                }

                gallery.forEach((g, i) => {
                    const item = document.createElement('div');
                    item.className = 'gallery-item';
                    item.title = g.file.name + ' - ' + formatSize(g.file.size);

                    const img = document.createElement('img');
                    img.src = g.url;
                    img.alt = g.file.name;

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'remove';
                    btn.setAttribute('aria-label', 'حذف الصورة');
                    btn.innerHTML = '<i class="fas fa-times"></i>';
                    btn.addEventListener('click', () => {
                        URL.revokeObjectURL(g.url);
                        gallery.splice(i, 1);
                        syncGallery();
                    });

                    item.append(img, btn);
                    grid.appendChild(item);
                });
            }

            galleryInput.addEventListener('change', () => addGalleryFiles(galleryInput.files));
            bindDrop($('galleryZone'), addGalleryFiles);

            $('galleryClear').addEventListener('click', () => {
                gallery.forEach(g => URL.revokeObjectURL(g.url));
                gallery = [];
                syncGallery();
            });

            renderGallery();

            /* ================= المواصفات ================= */
            const MAX_SPECS = 5;
            const specsList = $('specsList'),
                addBtn = $('addSpec'),
                counter = $('specCounter');

            function refreshSpecs() {
                const rows = specsList.querySelectorAll('.spec-row');
                rows.forEach((row, i) => {
                    const [k_ar, k_en, v_ar, v_en] = row.querySelectorAll('input');
                    k_ar.name = `specs[${i}][key_ar]`;
                    k_en.name = `specs[${i}][key_en]`;
                    v_ar.name = `specs[${i}][value_ar]`;
                    v_en.name = `specs[${i}][value_en]`;
                });
                counter.textContent = `${rows.length} / ${MAX_SPECS}`;
                addBtn.disabled = rows.length >= MAX_SPECS;
            }

            addBtn.addEventListener('click', () => {
                if (specsList.children.length >= MAX_SPECS) return;
                const row = document.createElement('div');
                row.className = 'spec-row';
                row.innerHTML =
                    `
                    <input type="text" class="form-control" placeholder="اسم المواصفة (عربي)">
                    <input type="text" class="form-control" placeholder="Spec Key (English)" dir="ltr">
                    <input type="text" class="form-control" placeholder="القيمة (عربي)">
                    <input type="text" class="form-control" placeholder="Value (English)" dir="ltr">
                    <button type="button" class="btn-remove-spec" title="حذف المواصفة" aria-label="حذف المواصفة"><i class="fas fa-trash-alt"></i></button>`;
                specsList.appendChild(row);
                refreshSpecs();
                row.querySelector('input').focus();
            });

            specsList.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-remove-spec');
                if (!btn) return;
                const row = btn.closest('.spec-row');
                if (specsList.children.length === 1) {
                    row.querySelectorAll('input').forEach(i => i.value = '');
                } else {
                    row.remove();
                }
                refreshSpecs();
            });

            refreshSpecs();

            /* ================= الإرسال ================= */
            const form = $('productForm'),
                submitBtn = $('submitBtn');

            form.addEventListener('submit', (e) => {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    form.reportValidity();
                    return;
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm ml-1"></span> جارٍ الحفظ...';
            });
        })();
    </script>
@endsection
