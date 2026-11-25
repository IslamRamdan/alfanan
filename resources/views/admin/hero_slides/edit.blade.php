@extends('adminlte::page')

@section('title', 'تعديل صورة السلايدر')

@section('content_header')
    <h1>تعديل صورة السلايدر</h1>
@stop

@section('content')
    <div class="card card-info">
        <form action="{{ route('admin.hero-slides.update', $heroSlide) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                @include('admin.hero_slides._form', ['slide' => $heroSlide])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">تحديث</button>
                <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary">رجوع</a>
            </div>
        </form>
    </div>
@stop
