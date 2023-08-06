@extends('layouts.auth')

@section('title', 'إعادة تعيين كلمة المرور')

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
                    <form method="POST" action="{{ route('provider.changePassword') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="new_password" style="float: {{ floating('right', 'left') }};">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password">
                            @error('new_password')
                            <span role="alert" class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation" style="float: {{ floating('right', 'left') }};">تأكيد كلمة المرور الجدبدة</label>
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="{{ trans('back.send') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
