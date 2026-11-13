@extends('adminlte::page')

@section('title', 'إضافة مدونة جديدة')

@section('content_header')
    <h1>إضافة مدونة جديدة</h1>
@stop

@section('css')
    <style>
        .blog-form .card {
            border-radius: .5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .blog-form .card-header {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: .85rem 1.25rem;
        }

        .blog-form .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .blog-form .card-title i {
            margin-inline-end: .5rem;
        }

        .blog-form .form-group label {
            font-weight: 600;
            color: #343a40;
            margin-bottom: .35rem;
        }

        .blog-form .form-control {
            border-radius: .35rem;
            min-height: 42px;
        }

        .blog-form textarea.form-control {
            min-height: auto;
            line-height: 1.8;
        }

        .blog-form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 .15rem rgba(0, 123, 255, .15);
        }

        /* اتجاه الحقول: العربي RTL والإنجليزي LTR */
        .blog-form [lang="ar"] {
            direction: rtl;
            text-align: right;
        }

        .blog-form [lang="en"] {
            direction: ltr;
            text-align: left;
        }

        .lang-badge {
            display: inline-block;
            font-size: .7rem;
            font-weight: 700;
            padding: .1rem .45rem;
            border-radius: .25rem;
            margin-inline-start: .4rem;
            vertical-align: middle;
        }

        .lang-badge.ar {
            background: #e7f1ff;
            color: #0b5ed7;
        }

        .lang-badge.en {
            background: #e9f7ef;
            color: #198754;
        }

        .char-counter {
            font-size: .78rem;
            color: #6c757d;
            margin-top: .25rem;
            text-align: end;
        }

        .char-counter.over {
            color: #dc3545;
            font-weight: 600;
        }

        /* رفع الصورة */
        .image-drop {
            border: 2px dashed #ced4da;
            border-radius: .5rem;
            padding: 1.25rem;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: border-color .15s, background .15s;
        }

        .image-drop:hover,
        .image-drop.dragover {
            border-color: #007bff;
            background: #f1f7ff;
        }

        .image-drop i {
            font-size: 2rem;
            color: #adb5bd;
        }

        .image-drop input[type="file"] {
            display: none;
        }

        .image-preview {
            display: none;
            max-height: 240px;
            max-width: 100%;
            border-radius: .5rem;
            margin: 0 auto;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
        }

        .image-drop.has-image i,
        .image-drop.has-image .drop-hint {
            display: none;
        }

        .image-drop.has-image .image-preview {
            display: block;
        }

        .file-name {
            font-size: .85rem;
            color: #6c757d;
            margin-top: .5rem;
            direction: ltr;
        }

        /* شريط الحفظ */
        .form-actions {
            position: sticky;
            bottom: 0;
            z-index: 5;
            background: #fff;
            border-top: 1px solid #e9ecef;
            padding: .85rem 1.25rem;
            border-radius: 0 0 .5rem .5rem;
            display: flex;
            gap: .5rem;
        }

        .form-actions .btn {
            min-width: 130px;
            border-radius: .35rem;
            font-weight: 600;
        }

        .blog-form .alert ul {
            padding-inline-start: 1.25rem;
        }

        @media (max-width: 767.98px) {
            .form-actions .btn {
                flex: 1;
                min-width: 0;
            }
        }
    </style>
@stop

@section('content')
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="blog-form">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- المحتوى الأساسي --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-pen-nib text-primary"></i> المحتوى</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="title_ar">العنوان (عربي)</label>
                        <input type="text" id="title_ar" name="title_ar" lang="ar"
                            class="form-control @error('title_ar') is-invalid @enderror" value="{{ old('title_ar') }}"
                            required>
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="title_en">العنوان (إنجليزي)</label>
                        <input type="text" id="title_en" name="title_en" lang="en"
                            class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}"
                            required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="description_ar">الوصف والمحتوى (عربي)</label>
                        <textarea id="description_ar" name="description_ar" rows="6" lang="ar"
                            class="form-control @error('description_ar') is-invalid @enderror" required>{{ old('description_ar') }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="description_en">الوصف والمحتوى (إنجليزي)</label>
                        <textarea id="description_en" name="description_en" rows="6" lang="en"
                            class="form-control @error('description_en') is-invalid @enderror" required>{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- الصورة --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-image text-primary"></i> صورة المدونة</h3>
            </div>
            <div class="card-body">
                <label class="image-drop d-block mb-0 @error('image') border-danger @enderror" id="imageDrop"
                    for="image">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <img src="" alt="" class="image-preview" id="imagePreview">
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <div class="file-name" id="fileName"></div>
                </label>
                @error('image')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- SEO --}}
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-search text-info"></i> إعدادات محركات البحث (SEO)</h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="meta_title_ar">متا تايتل (عربي)</label>
                        <input type="text" id="meta_title_ar" name="meta_title_ar" lang="ar"
                            class="form-control @error('meta_title_ar') is-invalid @enderror"
                            value="{{ old('meta_title_ar') }}" data-counter="60">
                        <div class="char-counter"></div>
                        @error('meta_title_ar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="meta_title_en">متا تايتل (إنجليزي)</label>
                        <input type="text" id="meta_title_en" name="meta_title_en" lang="en"
                            class="form-control @error('meta_title_en') is-invalid @enderror"
                            value="{{ old('meta_title_en') }}" data-counter="60">
                        <div class="char-counter"></div>
                        @error('meta_title_en')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="meta_description_ar">متا وصف (عربي)</label>
                        <textarea id="meta_description_ar" name="meta_description_ar" rows="3" lang="ar"
                            class="form-control @error('meta_description_ar') is-invalid @enderror" data-counter="160">{{ old('meta_description_ar') }}</textarea>
                        <div class="char-counter"></div>
                        @error('meta_description_ar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="meta_description_en">متا وصف (إنجليزي)</label>
                        <textarea id="meta_description_en" name="meta_description_en" rows="3" lang="en"
                            class="form-control @error('meta_description_en') is-invalid @enderror" data-counter="160">{{ old('meta_description_en') }}</textarea>
                        <div class="char-counter"></div>
                        @error('meta_description_en')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-md-0">
                        <label for="meta_keywords_ar">الكلمات المفتاحية (عربي)</label>
                        <input type="text" id="meta_keywords_ar" name="meta_keywords_ar" lang="ar"
                            class="form-control @error('meta_keywords_ar') is-invalid @enderror"
                            placeholder="كلمة1, كلمة2" value="{{ old('meta_keywords_ar') }}">
                        @error('meta_keywords_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-0">
                        <label for="meta_keywords_en">الكلمات المفتاحية (إنجليزي)</label>
                        <input type="text" id="meta_keywords_en" name="meta_keywords_en" lang="en"
                            class="form-control @error('meta_keywords_en') is-invalid @enderror"
                            placeholder="keyword1, keyword2" value="{{ old('meta_keywords_en') }}">
                        @error('meta_keywords_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ المدونة</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
@stop

@section('js')
    <script>
        (function() {
            // عدّاد الحروف لحقول الـ SEO
            document.querySelectorAll('[data-counter]').forEach(function(el) {
                var max = parseInt(el.dataset.counter, 10);
                var out = el.parentElement.querySelector('.char-counter');
                var update = function() {
                    var len = el.value.length;
                    out.textContent = len + ' / ' + max;
                    out.classList.toggle('over', len > max);
                };
                el.addEventListener('input', update);
                update();
            });

            // معاينة الصورة + السحب والإفلات
            var drop = document.getElementById('imageDrop');
            var input = document.getElementById('image');
            var preview = document.getElementById('imagePreview');
            var fileName = document.getElementById('fileName');

            var showPreview = function() {
                var file = input.files && input.files[0];
                if (!file) {
                    drop.classList.remove('has-image');
                    fileName.textContent = '';
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    drop.classList.add('has-image');
                };
                reader.readAsDataURL(file);
                fileName.textContent = file.name;
            };

            input.addEventListener('change', showPreview);

            ['dragenter', 'dragover'].forEach(function(evt) {
                drop.addEventListener(evt, function(e) {
                    e.preventDefault();
                    drop.classList.add('dragover');
                });
            });
            ['dragleave', 'drop'].forEach(function(evt) {
                drop.addEventListener(evt, function(e) {
                    e.preventDefault();
                    drop.classList.remove('dragover');
                });
            });
            drop.addEventListener('drop', function(e) {
                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    showPreview();
                }
            });
        })();
    </script>
@stop
