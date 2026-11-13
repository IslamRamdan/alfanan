@extends('adminlte::page')

@section('title', 'لوحة التحكم')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">لوحة التحكم الرئيسية</h1>
            <small class="text-muted">مرحباً بك مجدداً، نظرة عامة على إحصائيات المتجر</small>
        </div>
        <div class="mt-2 mt-md-0">
            <span class="badge badge-light p-2 shadow-sm" style="font-size: 0.9rem; border-radius: 8px;">
                <i class="fas fa-calendar-alt text-primary ml-1"></i> {{ date('Y-m-d') }}
            </span>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .dashboard-wrapper {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            --pf-primary: #0d6efd;
            --pf-border: #d9dee7;
            --pf-radius: 10px;
        }

        .dashboard-wrapper .small-box {
            border-radius: var(--pf-radius);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
            overflow: hidden;
        }

        .dashboard-wrapper .card {
            border: 1px solid var(--pf-border);
            border-radius: var(--pf-radius);
            box-shadow: none;
            margin-bottom: 1.25rem;
        }

        .dashboard-wrapper .card-header {
            background: #fff;
            border-bottom: 1px solid var(--pf-border);
            border-radius: var(--pf-radius) var(--pf-radius) 0 0;
            padding: .9rem 1.25rem;
        }

        .dashboard-wrapper .card-title {
            font-weight: 700;
            font-size: 1.05rem;
            margin: 0;
        }

        .product-thumbnail {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--pf-border);
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-wrapper" dir="rtl">

        {{-- بطاقات الإحصائيات السريعة (Widgets) --}}
        <div class="row">
            <!-- إجمالي الأقسام الرئيسية -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $categoriesCount ?? 0 }}</h3>
                        <p>الأقسام الرئيسية</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <a href="{{ route('admin.categories.index') }}" class="small-box-footer">
                        عرض التفاصيل <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
            </div>

            <!-- إجمالي الأقسام الفرعية -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $subCategoriesCount ?? 0 }}</h3>
                        <p>الأقسام الفرعية</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <a href="{{ route('admin.sub-categories.index') }}" class="small-box-footer">
                        عرض التفاصيل <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
            </div>

            <!-- إجمالي المنتجات -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner text-dark">
                        <h3>{{ $productsCount ?? 0 }}</h3>
                        <p>إجمالي المنتجات</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box-open text-dark"></i>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="small-box-footer text-dark">
                        عرض التفاصيل <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
            </div>

            <!-- إجمالي القيم / الأسعار -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ number_format($totalInventoryValue ?? 0, 0) }}</h3>
                        <p>إجمالي أسعار المنتجات</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                        إدارة المنتجات <i class="fas fa-arrow-circle-left"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- قسم الرسوم البيانية (Charts) --}}
        <div class="row">
            <!-- الرسم البياني الأول: نظرة عامة على المحتوى -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">إحصائيات النظام العامة</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الرسم البياني الثاني: التوزيع النسبي (Pie Chart) -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">توزيع العناصر</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول أحدث المنتجات المضافة --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">أحدث المنتجات المضافة للمتجر</h3>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary"
                            style="border-radius: 6px;">عرض الكل</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 text-right">
                                <thead>
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th style="width: 70px">الصورة</th>
                                        <th>اسم المنتج</th>
                                        <th>القسم الفرعي</th>
                                        <th>السعر</th>
                                        <th>تاريخ الإضافة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestProducts ?? [] as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ asset($product->image) }}" alt=""
                                                    class="product-thumbnail">
                                            </td>
                                            <td class="font-weight-bold">{{ $product->name }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-info">{{ $product->subCategory->name ?? 'غير محدد' }}</span>
                                            </td>
                                            <td class="text-success font-weight-bold">
                                                {{ number_format($product->price, 2) }} ر.س</td>
                                            <td class="text-muted small">{{ $product->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-3 text-muted">لا توجد منتجات حديثة.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <!-- تضمين مكتبة Chart.js عبر CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // بيانات الأرقام القادمة من الباك إند
            const categoriesCount = {{ $categoriesCount ?? 0 }};
            const subCategoriesCount = {{ $subCategoriesCount ?? 0 }};
            const productsCount = {{ $productsCount ?? 0 }};

            // 1. إعداد الـ Bar Chart (الأعمدة)
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['الأقسام الرئيسية', 'الأقسام الفرعية', 'المنتجات'],
                    datasets: [{
                        label: 'العدد الإجمالي',
                        data: [categoriesCount, subCategoriesCount, productsCount],
                        backgroundColor: ['#17a2b8', '#28a745', '#ffc107'],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // 2. إعداد الـ Pie Chart (الدائري)
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['أقسام رئيسية', 'أقسام فرعية', 'منتجات'],
                    datasets: [{
                        data: [categoriesCount, subCategoriesCount, productsCount],
                        backgroundColor: ['#17a2b8', '#28a745', '#ffc107']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection
