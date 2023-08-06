<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ direction() }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', trans('back.login'))</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {!! meta('viewport', 'width=device-width, initial-scale=1.0') !!}
    {!! meta('description', getSetting('contact_description', true)) !!}
    {!! meta('author', 'Coderthemes') !!}

    <!-- App favicon -->
    {!! style('admin/images/favicon.png', ['rel' => 'shortcut icon']) !!}

    <!-- App css -->
    {!! Html::style('https://fontlibrary.org/face/droid-arabic-kufi', ['media' => 'screen']) !!}
    {!! style('admin/css/bootstrap.min.css') !!}
    {!! style('admin/css/icons.min.css') !!}
    {!! style('admin/css/app.min.css') !!}
    <style>
        :root {
            --main: #5f634a;
            --main-hover: #8C9173;
            --nav-active: #50552dd1;
        }

        body, h4, h2, h3, h1, h5, h6, label, span {
            font-family: 'DroidArabicKufiRegular', serif;
        }
        .btn-main-color {
            color: #ffffff;
            background-color: var(--main);
            border-color: var(--main);
        }
        .btn-main-color:hover {
            color: #ffffff;
            background-color: var(--main-hover);
            border-color: var(--main-hover);
        }

        .checkbox-info input[type=checkbox]:checked+label::before {
            background-color: #5f634a;
            border-color: #5f634a;
        }
    </style>
</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        @yield('content')
    </div>
</div>

<footer class="footer footer-alt">
    @lang('back.copyrights', ['var' => date('Y')]) <a href="{{ url('https://wesal.com.sa/') }}" class="text-muted">@lang('back.wesal')</a>
</footer>

{!! script('admin/js/vendor.min.js') !!}
{!! script('admin/js/app.min.js') !!}

</body>
</html>
