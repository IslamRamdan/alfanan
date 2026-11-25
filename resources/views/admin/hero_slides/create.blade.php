@extends('adminlte::page')

@section('title', 'إضافة صورة للسلايدر')

@section('content_header')
    <h1>إضافة صورة للسلايدر</h1>
@stop

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @include('admin.hero_slides._form')
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary">رجوع</a>
            </div>
        </form>
    </div>
@stop
