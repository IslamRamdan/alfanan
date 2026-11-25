@extends('adminlte::page')

@section('title', 'العملاء والشركاء')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>العملاء والشركاء</h1>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة عميل
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
                        <th>اسم العميل</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->sort_order }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}"
                                    style="width: 90px; height: 55px; object-fit: contain; border-radius: 6px;">
                            </td>
                            <td>{{ $client->name }}</td>
                            <td>
                                @if ($client->is_active)
                                    <span class="badge badge-success">مفعّل</span>
                                @else
                                    <span class="badge badge-danger">مخفي</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
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
                            <td colspan="5" class="text-center py-4">لا يوجد عملاء مضافون حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
