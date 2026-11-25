@extends('adminlte::page')

@section('title', 'إدارة الباقات')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>إدارة الباقات</h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة باقة جديدة
        </a>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>الترتيب</th>
                        <th>الأيقونة</th>
                        <th>اسم الباقة</th>
                        <th>السعر</th>
                        <th>الشارة</th>
                        <th>الأكثر طلباً</th>
                        <th>الحالة</th>
                        <th>المميزات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td>{{ $package->sort_order }}</td>
                            <td><i class="{{ $package->icon ?: 'fas fa-box-open' }} fa-lg"></i></td>
                            <td>
                                <strong>{{ $package->name }}</strong>
                                @if ($package->name_en)
                                    <br><small class="text-info">{{ $package->name_en }}</small>
                                @endif
                                @if ($package->description)
                                    <br><small class="text-muted">{{ Str::limit($package->description, 45) }}</small>
                                @endif
                            </td>
                            <td>{{ number_format($package->price, 0) }} {{ $package->currency }}</td>
                            <td>
                                @if ($package->badge)
                                    <span class="badge badge-warning">{{ $package->badge }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($package->is_featured)
                                    <span class="badge badge-success">نعم</span>
                                @else
                                    <span class="badge badge-secondary">لا</span>
                                @endif
                            </td>
                            <td>
                                @if ($package->is_active)
                                    <span class="badge badge-primary">مفعّلة</span>
                                @else
                                    <span class="badge badge-danger">مخفية</span>
                                @endif
                            </td>
                            <td>{{ count($package->features ?? []) }} ميزة</td>
                            <td>
                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">لا توجد باقات مضافة حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
