<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ direction() }}">
<head>
    <meta charset="utf-8"/>
    <title> لوحة تحكم التاجر || @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ getTransSetting('contact_description') }}" name="description"/>
    <meta content="Wesal-international" name="author"/>
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="{{ getSetting('map_api') }}" name="map_api_key"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="format-detection" content="telephone=yes">

    @if(env('APP_ENV') == 'production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset_url('admin/images/favicon.png') }}">

    <!-- Styles -->
    @include('Provider.layouts.partials.styles')

    @yield('styles')
</head>

<body class="left-side-menu-light topbar-dark">

<div id="wrapper">
    <div id="preloader">
        <div id="status">
            <div class="spinner">Loading...</div>
        </div>
    </div>

    @include('Provider.layouts.partials.top-bar')

    @include('Provider.layouts.partials.sidebar')

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                @yield('page_header')

                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('Provider.layouts.partials.right-side-bar')

<div class="rightbar-overlay"></div>

<div id="site-modals"></div>

@include('Provider.layouts.partials.scripts')

@yield('scripts')

</body>
</html>
