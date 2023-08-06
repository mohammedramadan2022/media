<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ direction() }}">
<head>
    <meta charset="utf-8"/>
    <title> لوحة التحكم || @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ getTransSetting('contact_description', true) }}" name="description"/>
    <meta content="Wesal-international" name="author"/>
    <meta content="{{ csrf_token() }}" name="csrf-token"/>
    <meta content="{{ getSetting('map_api', true) }}" name="map_api_key"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="format-detection" content="telephone=yes">

    @if(app()->isProduction())
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset_url('admin/images/favicon.png') }}">

    @include('Back.includes.seo-meta-tags', seo())

    <!-- Styles -->
    @include('Back.layouts.partials.styles')

    @yield('styles')
</head>

<body class="left-side-menu-light topbar-dark">

<div id="wrapper">
    <div id="preloader">
        <div id="status">
            <div class="spinner">Loading...</div>
        </div>
    </div>

    @include('Back.layouts.partials.top-bar')

    @include('Back.layouts.partials.sidebar')

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                @yield('page_header')

                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('Back.layouts.partials.right-side-bar')

<div class="rightbar-overlay"></div>

<div id="site-modals"></div>

@include('Back.layouts.partials.scripts')

@yield('scripts')

</body>
</html>
