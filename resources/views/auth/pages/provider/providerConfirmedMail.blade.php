@extends('layouts.auth')

@section('title', 'تأكيد الإرسال')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="text-center">
                <a href="{{ route('admin-panel') }}">
                    <span><img src="{{ main_mail_logo_url() }}" alt="" height="80"></span>
                </a>
                <p class="text-muted mt-2 mb-4">لوحة تحكم الاستاذ</p>
            </div>
            <div class="card text-center">

                <div class="card-body p-4">

                    <div class="mb-4">
                        <h4 class="text-uppercase mt-0">تأكيد الإرسال</h4>
                    </div>
                    <img src="{{ asset('public/admin/images/mail_confirm.png') }}" alt="img" width="86" class="mx-auto d-block" />

                    <p class="text-muted font-14 mt-2" dir="rtl"> تم إرسال رسالة بريد إلكتروني علي <b>{{ session()->has('email') ? session('email') : 'site@mail.com' }}
                            <br></b>. من فضلك تاكد من الكود المرسال اليك ,,,, </p>

                    <a href="{{ route('provider-panel') }}" class="btn btn-block btn-pink waves-effect waves-light mt-3">العودة للرئيسية</a>
                </div>
            </div>
        </div>
    </div>
@stop


