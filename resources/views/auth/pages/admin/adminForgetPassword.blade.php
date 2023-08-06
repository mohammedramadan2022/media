@extends('layouts.auth')

@section('title', 'إستعادة كلمة المرور')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">

            <div class="card-body p-4">
                @include('includes.flash')

                <div class="text-center w-75 m-auto">
                    <a href="{{ route('admin-panel') }}">
                        <span><img src="{{ main_logo_url() }}" alt="" width="100" height="100"></span>
                    </a>
                    <p class="text-muted mb-4 mt-3">أدخل عنوان بريدك الإلكتروني وسنرسل إليك بريدًا إلكترونيًا يحتوي على إرشادات لإعادة تعيين كلمة المرور الخاصة بك.</p>
                </div>

                <h5 class="auth-title">إستعادة كلمة المرور</h5>

                <form action="{{ route('admin.forget-password-submit') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="emailaddress" style="float: {{ floating('right', 'left') }};">@lang('back.form-email')</label>
                        <input dir="ltr" class="form-control @error('email') is-invalid @enderror" name="email" type="email" id="emailaddress" placeholder="أدخل البريد الالكتروني">
                        @error('email') <strong class="invalid-feedback">{{ $message }}</strong> @enderror
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-main-color btn-block" type="submit"> إعادة تعيين كلمة المرور </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="text-muted">العودة لـ <a href="{{ route('admin.login') }}" class="text-muted ml-1"><b class="font-weight-semibold">@lang('back.login')</b></a></p>
            </div>
        </div>
    </div>
</div>
@stop
