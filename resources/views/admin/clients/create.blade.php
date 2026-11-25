{{-- create.blade.php --}}
@extends('adminlte::page')

@section('title', 'إضافة عميل')

@section('content_header')
    <h1>إضافة عميل</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @include('admin.clients._form')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">رجوع</a>
            </div>
        </form>
    </div>
@stop
