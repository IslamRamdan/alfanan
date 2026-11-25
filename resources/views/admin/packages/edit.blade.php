@extends('adminlte::page')

@section('title', 'تعديل الباقة')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fas fa-edit text-info ml-2"></i>
                    تعديل: {{ $package->name }}
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.packages.index') }}">الباقات</a>
                    </li>
                    <li class="breadcrumb-item active">تعديل باقة</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                {{-- رسالة نجاح --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <i class="icon fas fa-check-circle ml-1"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- أخطاء التحقق --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="mb-2">
                            <i class="icon fas fa-exclamation-triangle"></i>
                            يوجد أخطاء في البيانات المدخلة
                        </h5>
                        <ul class="mb-0 pr-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card card-info card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-box-open ml-1"></i>
                            بيانات الباقة
                        </h3>
                    </div>

                    <form id="package-form" action="{{ route('admin.packages.update', $package) }}" method="POST"
                        novalidate>
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            @include('admin.packages._form', ['package' => $package])
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.packages.index') }}" class="btn btn-default">
                                <i class="fas fa-arrow-right ml-1"></i>
                                رجوع
                            </a>

                            <button type="submit" id="submit-btn" class="btn btn-info px-4">
                                <i class="fas fa-sync-alt ml-1"></i>
                                تحديث الباقة
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .content-wrapper {
            text-align: right;
        }

        .card-title {
            float: right;
        }

        .form-group label {
            font-weight: 600;
        }

        .form-control:focus {
            box-shadow: 0 0 0 .15rem rgba(23, 162, 184, .25);
        }

        .card-footer .btn {
            min-width: 110px;
        }
    </style>
@stop

@section('js')
    @include('admin.packages._scripts')

    <script>
        // منع الضغط المتكرر على زر التحديث
        document.getElementById('package-form').addEventListener('submit', function() {
            const btn = document.getElementById('submit-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin ml-1"></i> جاري التحديث...';
        });
    </script>
@stop
