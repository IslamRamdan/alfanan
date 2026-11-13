@extends('adminlte::page')

@section('title', 'إدارة المنتجات')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">إدارة المنتجات</h1>
            <small class="text-muted">عرض وإدارة جميع المنتجات المضافة في المتجر بالعربية والإنجليزية</small>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary font-weight-bold shadow-sm"
                style="border-radius: 8px;">
                <i class="fas fa-plus ml-1"></i> إضافة منتج جديد
            </a>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .products-index {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            --pf-primary: #0d6efd;
            --pf-primary-soft: #eaf2ff;
            --pf-border: #d9dee7;
            --pf-muted: #6b7686;
            --pf-danger: #dc3545;
            --pf-radius: 10px;
        }

        .products-index .card {
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            box-shadow: none;
            margin-bottom: 1.25rem;
        }

        .products-index .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pf-border);
            border-radius: var(--pf-radius) var(--pf-radius) 0 0;
            padding: .9rem 1.25rem;
        }

        .products-index .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .products-index .table th {
            border-top: none;
            color: #334155;
            font-weight: 700;
            background-color: #f8fafc;
        }

        .products-index .table td {
            vertical-align: middle;
            color: #1f2937;
        }

        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--pf-border);
            background: #f1f4f8;
        }

        .badge-subcat {
            background-color: var(--pf-primary-soft);
            color: var(--pf-primary);
            font-weight: 600;
            padding: .35rem .65rem;
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
    <div class="products-index" dir="rtl">
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
                <h3 class="card-title">قائمة المنتجات</h3>
                <span class="badge badge-secondary px-2 py-1" style="font-size: 0.85rem;">
                    إجمالي المنتجات: {{ $products->total() ?? count($products) }}
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-right">
                        <thead>
                            <tr>
                                <th style="width: 60px">#</th>
                                <th style="width: 80px">الصورة</th>
                                <th>اسم المنتج (عربي)</th>
                                <th>Product Name (English)</th>
                                <th>السعر</th>
                                <th>القسم الفرعي</th>
                                <th style="width: 150px" class="text-center">التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset($product->image) }}"
                                            alt="{{ $product->name_ar ?? $product->name }}" class="product-thumbnail">
                                    </td>
                                    <td class="font-weight-bold">
                                        {{ $product->name_ar ?? $product->name }}
                                    </td>
                                    <td class="text-muted" dir="ltr">
                                        {{ $product->name_en ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="text-success font-weight-bold">{{ number_format($product->price, 2) }}
                                            ر.س</span>
                                    </td>
                                    <td>
                                        <span class="badge-subcat">
                                            {{ $product->subCategory->name_ar ?? ($product->subCategory->name ?? 'غير محدد') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-sm btn-info btn-action ml-1" title="تعديل">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج نهائياً؟');">
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
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                        لا توجد منتجات مضافة حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($products->hasPages())
                <div class="card-footer clearfix bg-white">
                    <div class="float-right">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
