<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="mdi mdi-close"></i>
        </a>
        <h5 class="m-0 text-white">مرحبا بك</h5>
    </div>
    <div class="slimscroll-menu">
        <div class="user-box">
            <div class="user-img">
                <img src="{{ auth()->guard('provider')->user()->logo_url }}" class="rounded-circle" width="70" height="70" alt="">
{{--                <i class="fa fa-user fa-2x bg-primary text-white p-3 rounded-circle"></i>--}}
            </div>

            <h5><a href="{{ route('provider.profile') }}">{{ ucwords(auth()->guard('provider')->user()->name) }}</a></h5>
            <p class="text-muted mb-0"><small>{{ ucwords(auth()->guard('provider')->user()->store_name) }}</small></p>
        </div>
    </div>
</div>
