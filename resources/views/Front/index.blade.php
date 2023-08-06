<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ direction() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/bootstrap/css/bootstrap.rtl.min.css') }}">

    <!-- owl carousel css -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/css/owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset_url('front/assets/css/owl/owl.theme.default.min.css') }}">
    <!-- live search css -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/css/select2/select2.min.css') }}">
    <!-- font-awesome CSS -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/fontawesome/css/all.min.css') }}">
    <!-- wow css -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/css/animate.css') }}">
    <!-- fancy box css -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/css/fancy-box.min.css') }}">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset_url('front/assets/css/custom_style.css') }}">

    <!-- ico icon -->
    <link rel="shortcut icon" href="{{ asset_url('front/assets/images/favicon.png') }}">
    <!-- title -->
    <title>Rental - رينتال</title>

    <script>
        window.root = '{{ root() }}';
        window.isLocal = '{{ env('APP_ENV') == 'local' }}';
    </script>
</head>
<body>

<div id="app">
    <router-view></router-view>
</div>

<!-- Scripts -->
<script src="{{ asset_url('js/app.js') }}"></script>

<!-- jquery js -->
<script src="{{ asset_url('front/assets/js/jquery.min.js') }}"></script>

<!-- owl carousel js -->
<script src="{{ asset_url('front/assets/js/owl/owl.carousel.min.js') }}"></script>

<!-- live search -->
<script src="{{ asset_url('front/assets/js/select2/select2.min.js') }}"></script>

<!-- wow js -->
<script src="{{ asset_url('front/assets/js/wow.min.js') }}"></script>
<script> new WOW().init(); </script>

<!-- fancy box js -->
<script src="{{ asset_url('front/assets/js/fancy-box.min.js') }}"></script>

<!-- custom js -->
<script src="{{ asset_url('front/assets/js/custom_script.js') }}"></script>
<!-- end of js scripts -->

<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/03234bd2e7b25ebf9ab6b3512/3923ecddb5f935b0ecc41d8f8.js");</script>

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js-eu1.hs-scripts.com/139513604.js"></script>
<!-- End of HubSpot Embed Code -->

{{--<script type="text/javascript">--}}
{{--    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();--}}
{{--    (function(){--}}
{{--        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];--}}
{{--        s1.async=true;--}}
{{--        s1.src='https://embed.tawk.to/6436beb64247f20fefeb3a5b/1gtqthue1';--}}
{{--        s1.charset='UTF-8';--}}
{{--        s1.setAttribute('crossorigin','*');--}}
{{--        s0.parentNode.insertBefore(s1,s0);--}}
{{--    })();--}}
{{--</script>--}}
</body>
</html>
