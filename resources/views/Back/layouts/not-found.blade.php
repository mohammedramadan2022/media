@extends('Back.layouts.master')
@section('title', '404')
@section('content')
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="error-ghost text-center">
                                <img src="/admin/images/error.svg" width="200" alt="error-image"/>
                            </div>

                            <div class="text-center">
                                <h3 class="mt-4 text-uppercase font-weight-bold"> صفحة غير موجودة </h3>
                                <p class="text-muted mb-0 mt-3" style="line-height: 20px;">يبدو أنك ربما تكون قد اتخذت منحى خاطئًا. لا تقلق...
                                    يحدث لأفضل منا. قد ترغب في التحقق من اتصالك بالإنترنت ، وإليك بعض النصائح التي قد تساعدك على العودة إلى المسار الصحيح.</p>

                                <a class="btn btn-main-color mt-3" href="{{ route('admin-panel') }}"><i class="mdi mdi-reply mr-1"></i> العودة للرئيسية </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
