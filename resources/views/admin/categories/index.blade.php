@extends('adminlte::page')

@section('title', 'إدارة الأقسام')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">إدارة الأقسام الرئيسية</h1>
            <small class="text-muted">عرض وإدارة الأقسام الرئيسية في النظام بالعربية والإنجليزية</small>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary font-weight-bold shadow-sm"
                style="border-radius: 8px;">
                <i class="fas fa-plus ml-1"></i> إضافة قسم جديد
            </a>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .categories-index {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            --pf-primary: #0d6efd;
            --pf-primary-soft: #eaf2ff;
            --pf-border: #d9dee7;
            --pf-muted: #6b7686;
            --pf-danger: #dc3545;
            --pf-radius: 10px;
        }

        .categories-index .card {
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            box-shadow: none;
            margin-bottom: 1.25rem;
        }

        .categories-index .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pf-border);
            border-radius: var(--pf-radius) var(--pf-radius) 0 0;
            padding: .9rem 1.25rem;
        }

        .categories-index .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .categories-index .table th {
            border-top: none;
            color: #334155;
            font-weight: 700;
            background-color: #f8fafc;
        }

        .categories-index .table td {
            vertical-align: middle;
            color: #1f2937;
        }

        .btn-action {
            border-radius: 6px;
            padding: .3rem .6rem;
            font-size: .85rem;
        }
    </style>
@endsection

@section('content')
    <div class="categories-index" dir="rtl">
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
                <h3 class="card-title">قائمة الأقسام الرئيسية</h3>
                <span class="badge badge-secondary px-2 py-1" style="font-size: 0.85rem;">
                    الإجمالي: {{ $categories->total() ?? count($categories) }}
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-right">
                        <thead>
                            <tr>
                                <th style="width: 60px">#</th>
                                <th>اسم القسم (عربي)</th>
                                <th>Category Name (English)</th>
                                <th style="width: 160px" class="text-center">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">
                                        <i class="fas fa-folder text-primary ml-1"></i>
                                        {{ $category->name_ar ?? $category->name }}
                                    </td>
                                    <td class="text-muted" dir="ltr">
                                        {{ $category->name_en ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-info btn-action ml-1" title="تعديل">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟ سيتم حذف الأقسام التابعة له أيضاً.');">
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
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        لا توجد أقسام رئيسية مضافة حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($categories->hasPages())
                <div class="card-footer clearfix bg-white">
                    <div class="float-right">
                        {{ $categories->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
