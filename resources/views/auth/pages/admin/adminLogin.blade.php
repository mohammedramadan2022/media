@extends('layouts.auth')

@section('title', trans('back.login'))

@section('content')
    <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card">

            <div class="card-body p-4">
                @include('includes.flash')

                <div class="text-center w-75 m-auto">
                    <a href="javascript:void(0);">
                        <span><img src="{{ main_logo_url() }}" alt="" width="100" height="100"></span>
                    </a>
                    <p class="text-muted mb-4 mt-3">أدخل عنوان بريدك الإلكتروني وكلمة المرور للوصول إلى لوحة الإدارة.</p>
                </div>

                <h5 class="auth-title">@lang('back.login')</h5>

                <form method="POST" action="{{ route('admin.submit.login') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="emailaddress" style="float: {{ floating('right', 'left') }};">@lang('back.form-email')</label>
                        <input class="form-control @error('email') is-invalid @enderror" dir="ltr" name="email" type="email" id="emailaddress" placeholder="EX: email@example.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" style="float: {{ floating('right', 'left') }};">@lang('back.form-password')</label>
                        <input class="form-control @error('password') is-invalid @enderror" dir="ltr" type="password" name="password" id="password" placeholder="******">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3" style="float: {{ floating('right', 'left') }};">
                        <div class="custom-control custom-checkbox checkbox-info">
                            <input type="checkbox" name="remember" class="custom-control-input" id="checkbox-signin">
                            <label class="custom-control-label" for="checkbox-signin">تذكرني</label>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-main-color btn-block" type="submit"> @lang('back.login') </button>
                    </div>

                </form>

            </div> <!-- end card-body -->
        </div>
        <!-- end card -->

        <div class="row mt-3">
            <div class="col-12 text-center">
                <p> <a href="{{ route('admin.forget-password') }}" class="text-muted ml-1">نسيت كلمة المرور ؟</a></p>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- end col -->
</div>
@stop
