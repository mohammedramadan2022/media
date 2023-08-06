<!-- App css -->
{!! style('admin/css/bootstrap.min.css') !!}
{!! style('admin/css/app-rtl.min.css') !!}
{!! style('front/assets/fontawesome/css/all.css') !!}
{!! style('admin/css/icons.min.css') !!}
{!! style('admin/libs/jquery-nice-select/nice-select.css') !!}
{!! style('admin/libs/switchery/switchery.min.css') !!}
{!! style('admin/libs/select2/select2.min.css') !!}
{!! style('admin/libs/bootstrap-select/bootstrap-select.min.css') !!}
{!! style('admin/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.css') !!}
{!! style('admin/css/custom.css') !!}
{!! style('admin/libs/select2/select2.min.css') !!}
{!! style('admin/libs/jquery-toast/jquery.toast.min.css') !!}
{!! style('admin/css/HoldOn.min.css') !!}
{!! Html::style('https://fonts.gstatic.com', ['rel' => 'preconnect']) !!}
{!! Html::script('https://www.google.com/jsapi') !!}
{!! style('admin/libs/dropify/dropify.min.css') !!}
{!! script('admin/ckeditor/ckeditor.js') !!}
{!! style('admin/css/fontSize.css') !!}
{!! style('admin/css/blog-pagination.css') !!}
{!! style('admin/css/scroll.css') !!}
{!! style('admin/css/media.css') !!}
{!! style('admin/css/google-fonts.css') !!}
{!! Html::style('https://fastly.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css') !!}
{!! Html::style('https://fastly.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css') !!}

<style>
    :root {
        --main: #5f634a;
        --main-hover: #8C9173;
        --nav-active: #50552dd1;
    }

    @font-face {
        font-family: 'Roboto-Bold';
        src:  url('{{ asset_url('admin/fonts/Tajawal/Tajawal-Bold.ttf') }}') format('truetype');
    }
    @font-face {
        font-family: 'Roboto-Medium';
        src:  url('{{ asset_url('admin/fonts/Tajawal/Tajawal-Medium.ttf') }}') format('truetype');
    }

    table {
        text-align: center !important;
    }

    .logo-box {
        height: 70px;
        width: 240px;
        background-color: #ffffff;
    }

    .left-side-menu-light .left-side-menu #sidebar-menu>ul>li>a.active {
        color: #ffffff;
        background-color: var(--nav-active);
        border-right-color: #85889c;
    }

    .select2-container .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }

    .select2-container .select2-selection--multiple .select2-selection__choice {
        background-color: #5089de;
        border: none;
        color: #fff;
        border-radius: 3px;
        padding: 0 7px;
        margin-top: 7px;
    }

    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #fff;
        background-color: var(--main);
    }

    .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: var(--main);
        border-color: var(--main);
    }

    .left-side-menu-light .left-side-menu .nav-second-level li a:focus,
    .left-side-menu-light .left-side-menu .nav-second-level li a:hover,
    .left-side-menu-light .left-side-menu .nav-thrid-level li a:focus,
    .left-side-menu-light .left-side-menu .nav-thrid-level li a:hover {
        color: var(--main);
    }

    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
        color: #ffffff;
        font-weight: bold;
        background-color: var(--nav-active);
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .topbar-dark .navbar-custom .button-menu-mobile span {
        background-color: #ffffff;
    }

    .right-bar .rightbar-title {
        background-color: var(--main);
    }

    .topbar-dark .navbar-custom .topnav-menu .nav-link{
        color: #ffffff;
    }

    ::placeholder {
        color: #fff !important;
    }

    .text-main-color {
        color: var(--main);
    }

    .text-main-hover-color {
        color: var(--main-hover);
    }

    .radio-main-color input[type="radio"] + label::after {
        background-color: var(--main);
    }

    .radio-main-color input[type="radio"]:checked + label::before {
        border-color: var(--main);
    }

    .radio-main-color input[type="radio"]:checked + label::after {
        background-color: var(--main);
    }

    i.font-22.avatar-title.text-light {
        display: inline-flex;
    }

    .main-background-color {
        background-color: var(--main);
    }
    .main-border-color {
        border-color: var(--main);
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
    .topbar-dark .navbar-custom {
        background-color: var(--nav-active)!important;
    }
    .topbar-dark .navbar-custom .app-search .form-control {
        color: #fff;
        background-color: var(--main);
        border-color: #f1f5f7;
    }
    .topbar-dark .navbar-custom .app-search .btn {
        background-color: var(--main);
        color: #ced4da;
    }
    .spinner {
        border-left: 5px solid var(--main);
    }

    .badge-default {
        color: #0a001f;
        border: 2px solid #0a001f;
    }
    .unselectable {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .dropify-font-upload:before,
    .dropify-wrapper .dropify-message span.file-icon:before {
        content: '';
    }

    .left-side-menu-light .left-side-menu #sidebar-menu>ul>li>a:active,
    .left-side-menu-light .left-side-menu #sidebar-menu>ul>li>a:focus,
    .left-side-menu-light .left-side-menu #sidebar-menu>ul>li>a:hover {
        color: #d7ddbb;
    }

    .topbar-dark .navbar-custom .app-search input::-webkit-input-placeholder {
        color: #ffffff !important;
    }

    .left-side-menu-light .left-side-menu .nav-second-level li.active > a,
    .left-side-menu-light .left-side-menu .nav-third-level li.active > a {
        color: var(--main);
    }

    .checkbox-info input[type=checkbox]:checked+label::before {
        background-color: #5f634a;
        border-color: #5f634a;
    }

    .badge-outline-primary {
        color: #5089de;
        border-color: #5089de;
    }
</style>
