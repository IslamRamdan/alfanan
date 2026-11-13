@extends('adminlte::page')

@section('title', 'إدارة المدونات')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0">قائمة المدونات</h1>
            <small class="text-muted">إدارة مقالات الموقع وتعديلها وحذفها</small>
        </div>

        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mt-2 mt-md-0">
            <i class="fas fa-plus ml-1"></i> إضافة مدونة جديدة
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle ml-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-blog ml-1"></i>
                جميع المدونات
            </h3>

            <div class="card-tools">
                <span class="badge badge-primary badge-pill px-3 py-2">
                    الإجمالي: {{ $blogs->total() }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover blogs-table mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 60px">#</th>
                            <th class="text-center" style="width: 110px">الصورة</th>
                            <th>العنوان (عربي)</th>
                            <th>العنوان (إنجليزي)</th>
                            <th class="text-center" style="width: 130px">الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr>
                                <td class="text-center text-muted">
                                    {{ $blogs->firstItem() + $loop->index }}
                                </td>

                                <td class="text-center">
                                    @if ($blog->image)
                                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title_ar }}" class="blog-thumb">
                                    @else
                                        <span class="blog-thumb blog-thumb-empty">
                                            <i class="far fa-image"></i>
                                        </span>
                                    @endif
                                </td>

                                <td class="font-weight-bold">
                                    {{ \Illuminate\Support\Str::limit($blog->title_ar, 60) }}
                                </td>

                                <td dir="ltr" class="text-left text-secondary">
                                    {{ \Illuminate\Support\Str::limit($blog->title_en, 60) ?: '—' }}
                                </td>

                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                            class="btn btn-sm btn-outline-info" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه المدونة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"
                                                title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="far fa-folder-open fa-2x text-muted mb-2 d-block"></i>
                                    <div class="text-muted mb-3">لا توجد مدونات مضافة حالياً.</div>
                                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus ml-1"></i> أضف أول مدونة
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($blogs->hasPages())
            <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
                <small class="text-muted mb-2 mb-md-0">
                    عرض {{ $blogs->firstItem() }} - {{ $blogs->lastItem() }} من {{ $blogs->total() }}
                </small>

                <div>{{ $blogs->links() }}</div>
            </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        .blogs-table th,
        .blogs-table td {
            vertical-align: middle;
        }

        .blog-thumb {
            width: 72px;
            height: 52px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            display: inline-block;
        }

        .blog-thumb-empty {
            line-height: 52px;
            text-align: center;
            color: #adb5bd;
            background: #f4f6f9;
        }

        .btn-group form .btn-delete {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            margin-right: -1px;
        }

        /* تنسيق الـ pagination داخل الفوتر */
        .card-footer .pagination {
            margin: 0;
        }
    </style>
@stop
