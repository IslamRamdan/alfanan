@extends('adminlte::page')

@section('title', 'إدارة الأقسام الفرعية')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">إدارة الأقسام الفرعية</h1>
            <small class="text-muted">عرض وإدارة الأقسام الفرعية وربطها بالأقسام الرئيسية بالعربية والإنجليزية</small>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('admin.sub-categories.create') }}" class="btn btn-primary font-weight-bold shadow-sm"
                style="border-radius: 8px;">
                <i class="fas fa-plus ml-1"></i> إضافة قسم فرعي جديد
            </a>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .subcat-index {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            --pf-primary: #0d6efd;
            --pf-primary-soft: #eaf2ff;
            --pf-border: #d9dee7;
            --pf-muted: #6b7686;
            --pf-danger: #dc3545;
            --pf-radius: 10px;
        }

        .subcat-index .card {
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            box-shadow: none;
            margin-bottom: 1.25rem;
        }

        .subcat-index .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pf-border);
            border-radius: var(--pf-radius) var(--pf-radius) 0 0;
            padding: .9rem 1.25rem;
        }

        .subcat-index .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .subcat-index .table th {
            border-top: none;
            color: #334155;
            font-weight: 700;
            background-color: #f8fafc;
        }

        .subcat-index .table td {
            vertical-align: middle;
            color: #1f2937;
        }

        .badge-maincat {
            background-color: var(--pf-primary-soft);
            color: var(--pf-primary);
            font-weight: 600;
            padding: .35rem .75rem;
            border-radius: 20px;
            font-size: .8rem;
        }

        .btn-action {
            border-radius: 6px;
            padding: .3rem .6rem;
            font-size: .85rem;
        }
    </style>
@endsection

@section('content')
    <div class="subcat-index" dir="rtl">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"
                style="border-radius: 8px;">
                <i class="fas fa-check-circle ml-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">قائمة الأقسام الفرعية</h3>
                <span class="badge badge-secondary px-2 py-1" style="font-size: 0.85rem;">
                    الإجمالي: {{ $subCategories->total() ?? count($subCategories) }}
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-right">
                        <thead>
                            <tr>
                                <th style="width: 60px">#</th>
                                <th>اسم القسم الفرعي (عربي)</th>
                                <th>Sub-Category Name (English)</th>
                                <th>القسم الرئيسي التابع له</th>
                                <th style="width: 160px" class="text-center">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subCategories as $subCategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">
                                        {{ $subCategory->name_ar ?? $subCategory->name }}
                                    </td>
                                    <td class="text-muted" dir="ltr">
                                        {{ $subCategory->name_en ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge-maincat">
                                            <i class="fas fa-folder ml-1"></i>
                                            {{ $subCategory->category->name_ar ?? ($subCategory->category->name ?? 'غير محدد') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.sub-categories.edit', $subCategory->id) }}"
                                                class="btn btn-sm btn-info btn-action ml-1" title="تعديل">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <form action="{{ route('admin.sub-categories.destroy', $subCategory->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم الفرعي؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-action"
                                                    title="حذف">
                                                    <i class="fas fa-trash-alt"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        لا توجد أقسام فرعية مضافة حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($subCategories->hasPages())
                <div class="card-footer clearfix bg-white">
                    <div class="float-right">
                        {{ $subCategories->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
