@extends('layouts.auth')

@section('title', 'نسيت كلمة المرور')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="text-center">
                <a href="{{ route('admin-panel') }}">
                    <span><img src="{{ main_mail_logo_url() }}" alt="" height="80"></span>
                </a>
                <p class="text-muted mt-2 mb-4">لوحة تحكم الاستاذ</p>
            </div>
            <div class="card">

                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h4 class="text-uppercase mt-0 mb-3">إعادة ضبط كلمة المرور</h4>
                        <p class="text-muted mb-0 font-13">أدخل عنوان بريدك الإلكتروني وسنرسل إليك بريدًا إلكترونيًا يحتوي على تعليمات لإعادة تعيين كلمة المرور الخاصة بك.</p>
                    </div>

                    <form action="{{ route('provider.forget-password-submit') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" style="float: {{ floating('right', 'left') }};">@lang('back.form-email')</label>
                            <input name="email" class="form-control @error('email') is-invalid @enderror" type="email" id="email" placeholder="البريد الالكتروني هنا">
                            @error('email') <strong class="invalid-feedback">{{ $message }}</strong> @enderror
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit" name="submit"> إعادة ضبط </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">العودة لـ <a href="{{ route('provider.login') }}" class="text-dark ml-1"><b>@lang('back.login')</b></a></p>
                </div>
            </div>
        </div>
    </div>
@stop
