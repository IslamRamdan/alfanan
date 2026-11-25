@extends('adminlte::page')

@section('title', 'التواصل الاجتماعي وملف الشركة')

@section('content_header')
    <h1>التواصل الاجتماعي وملف الشركة (PDF)</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary">
        <form action="{{ route('admin.site-links.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>فيسبوك (Facebook)</label>
                            <input type="url" name="facebook" class="form-control"
                                value="{{ old('facebook', $siteLink->facebook) }}" placeholder="https://facebook.com/...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>إنستغرام (Instagram)</label>
                            <input type="url" name="instagram" class="form-control"
                                value="{{ old('instagram', $siteLink->instagram) }}"
                                placeholder="https://instagram.com/...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>تيك توك (TikTok)</label>
                            <input type="url" name="tiktok" class="form-control"
                                value="{{ old('tiktok', $siteLink->tiktok) }}" placeholder="https://tiktok.com/@...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>سناب شات (Snapchat)</label>
                            <input type="url" name="snapchat" class="form-control"
                                value="{{ old('snapchat', $siteLink->snapchat) }}"
                                placeholder="https://snapchat.com/add/...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>إكس / تويتر (X)</label>
                            <input type="url" name="x" class="form-control" value="{{ old('x', $siteLink->x) }}"
                                placeholder="https://x.com/...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>واتساب (WhatsApp)</label>
                            <input type="text" name="whatsapp" class="form-control"
                                value="{{ old('whatsapp', $siteLink->whatsapp) }}" placeholder="https://wa.me/966545953908">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>يوتيوب (YouTube)</label>
                            <input type="url" name="youtube" class="form-control"
                                value="{{ old('youtube', $siteLink->youtube) }}" placeholder="https://youtube.com/@...">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>لينكد إن (LinkedIn)</label>
                            <input type="url" name="linkedin" class="form-control"
                                value="{{ old('linkedin', $siteLink->linkedin) }}"
                                placeholder="https://linkedin.com/company/...">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <div class="form-group">
                            <label>ملف الشركة (PDF)</label>
                            <input type="file" name="company_profile_pdf" class="form-control-file"
                                accept="application/pdf,.pdf">
                            @if ($siteLink->company_profile_pdf)
                                <div class="mt-2">
                                    <a href="{{ $siteLink->company_profile_pdf }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-pdf"></i> عرض ملف PDF الحالي
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </div>
        </form>
    </div>
@stop
