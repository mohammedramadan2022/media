<html dir="{{ direction() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('back.login')</title>
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
                <h5 class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay=".8s">@Lang('back.activation-code')</h5>
                <p class="mt-3">@lang('back.activation-code-title')</p>
                <form action="{{ route('post.verification') }}" method="POST" class="mt-5 pt-4 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1s">
                    @csrf
                    <div class="form-group divide">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" maxlength="4"/>
                        @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="mt-5 gred-blue hvr-glow btn">@lang('back.send')</button>
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
