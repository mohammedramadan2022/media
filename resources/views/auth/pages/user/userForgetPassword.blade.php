<html dir="{{ direction() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('back.forget-password')</title>
    @include('includes.css')
</head>
<body>

<header class="log-head">
    <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('public/front/imgs/logo.png') }}" class="img-fluid" width="95" alt=""></a>
    </nav>
</header>

<!--==================================================================================================-->

<section class="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <h5 dir="rtl" class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay=".8s">@lang('back.reset-password')</h5>
                <p class="mt-3">@lang('back.reset-password-title')</p>
                <form action="{{ route('post.forget.password') }}" class="mt-5 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1s">
                    @csrf
                    <div class="form-group mb-5">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="formGroupExampleInput" placeholder="@lang('back.form-email')">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="mt-5 gred-blue hvr-glow btn">{{ trans('back.send') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-12">
                <div class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1s">
                    <img src="{{ asset('public/front/imgs/Group 1258.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

@include('includes.script')

</body>
</html>
