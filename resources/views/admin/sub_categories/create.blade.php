@extends('adminlte::page')

@section('title', 'إضافة قسم فرعي جديد')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">إضافة قسم فرعي جديد</h1>
            <small class="text-muted">ربط القسم الفرعي بالقسم الرئيسي المناسب وإدخال البيانات بالعربية والإنجليزية</small>
        </div>
        <ol class="breadcrumb float-sm-left mb-0 bg-transparent">
            <li class="breadcrumb-item"><a href="{{ route('admin.sub-categories.index') }}">الأقسام الفرعية</a></li>
            <li class="breadcrumb-item active">إضافة</li>
        </ol>
    </div>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .subcat-form {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            --pf-primary: #0d6efd;
            --pf-primary-soft: #eaf2ff;
            --pf-border: #d9dee7;
            --pf-muted: #6b7686;
            --pf-danger: #dc3545;
            --pf-radius: 10px;
        }

        .subcat-form .card {
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            box-shadow: none;
            margin-bottom: 1.25rem;
        }

        .subcat-form .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pf-border);
            border-radius: var(--pf-radius) var(--pf-radius) 0 0;
            padding: .9rem 1.25rem;
        }

        .subcat-form .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .subcat-form label.field-label {
            font-weight: 600;
            margin-bottom: .35rem;
            color: #334155;
        }

        .subcat-form .req {
            color: var(--pf-danger);
            margin-right: .2rem;
        }

        .subcat-form .form-control {
            border-radius: 8px;
            border-color: var(--pf-border);
            min-height: 44px;
        }

        .subcat-form .form-control:focus {
            border-color: var(--pf-primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        .subcat-form .field-error {
            color: var(--pf-danger);
            font-size: .85rem;
            margin-top: .3rem;
            display: block;
        }

        .subcat-form .card-footer {
            background: #fff;
            border-top: 1px solid var(--pf-border);
            border-radius: 0 0 var(--pf-radius) var(--pf-radius);
            padding: 1rem 1.25rem;
        }

        .subcat-form .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: .5rem 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="subcat-form" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm" style="border-radius: 8px;">
                        <strong>تعذّر حفظ القسم الفرعي. راجع الأخطاء التالية:</strong>
                        <ul class="mb-0 mt-2 pr-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">بيانات القسم الفرعي</h3>
                        <div class="text-muted small mt-1">قم بتحديد القسم الرئيسي وإدخال اسم القسم الفرعي بالعربية
                            والإنجليزية.</div>
                    </div>

                    <form action="{{ route('admin.sub-categories.store') }}" method="POST">
                        @csrf
                        <div class="card-body">

                            <!-- اختيار القسم الرئيسي -->
                            <div class="form-group mb-3">
                                <label class="field-label" for="category_id">اختر القسم الرئيسي <span
                                        class="req">*</span></label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                    id="category_id" required>
                                    <option value="">-- اختر القسم الرئيسي --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name_ar ?? $category->name }}
                                            {{ isset($category->name_en) ? ' (' . $category->name_en . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- اسم القسم الفرعي بالعربية -->
                            <div class="form-group mb-3">
                                <label class="field-label" for="name_ar">اسم القسم الفرعي (بالعربية) <span
                                        class="req">*</span></label>
                                <input type="text" name="name_ar"
                                    class="form-control @error('name_ar') is-invalid @enderror" id="name_ar"
                                    value="{{ old('name_ar') }}" placeholder="أدخل اسم القسم الفرعي بالعربية" required>
                                @error('name_ar')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- اسم القسم الفرعي بالإنجليزية -->
                            <div class="form-group mb-0" dir="ltr">
                                <label class="field-label float-right" for="name_en">Sub-Category Name (English) <span
                                        class="req">*</span></label>
                                <input type="text" name="name_en"
                                    class="form-control text-left @error('name_en') is-invalid @enderror" id="name_en"
                                    value="{{ old('name_en') }}" placeholder="Enter sub-category name in English" required>
                                @error('name_en')
                                    <span class="field-error text-right">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-save ml-1"></i> حفظ القسم الفرعي
                            </button>
                            <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
