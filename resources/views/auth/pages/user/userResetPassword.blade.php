<html dir="{{ direction() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('reset-password')</title>
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
                <h5 class="wow fadeIn" data-wow-duration="1.5s" data-wow-delay=".8s">@lang('back.reset-new-password')</h5>
                <p class="mt-3">@lang('back.set-new-password-title')</p>
                <form class="mt-5 wow fadeInRight" method="POST" action="{{ route('reset-password') }}" data-wow-duration="1.5s" data-wow-delay="1s">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <input type="password" name="newPassword" class="form-control @error('newPassword') is-invalid @enderror" id="exampleInputPassword1" placeholder="كلمة المرور الجديدة">
                        @error('newPassword') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="newPassword_confirmation" class="form-control" id="exampleInputPassword1" placeholder="تأكيد كلمة المرور الجديدة">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="mt-5 gred-blue hvr-glow btn">@lang('back.send')</button>
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
