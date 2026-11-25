@extends('adminlte::page')

@section('title', 'إدارة صور السلايدر')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>إدارة صور السلايدر</h1>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة صورة جديدة
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
                        <th>الصورة</th>
                        <th>عنوان توضيحي</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slides as $slide)
                        <tr>
                            <td>{{ $slide->sort_order }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="slide"
                                    style="width: 120px; height: 65px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td>{{ $slide->title ?: 'بدون عنوان' }}</td>
                            <td>
                                @if ($slide->is_active)
                                    <span class="badge badge-success">مفعّل</span>
                                @else
                                    <span class="badge badge-danger">مخفي</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟')">
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
                            <td colspan="5" class="text-center py-4">لا توجد صور في السلايدر حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
