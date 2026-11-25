{{-- edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'تعديل عميل')

@section('content_header')
    <h1>تعديل عميل</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                @include('admin.clients._form')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">تحديث</button>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">رجوع</a>
            </div>
        </form>
    </div>
@stop
