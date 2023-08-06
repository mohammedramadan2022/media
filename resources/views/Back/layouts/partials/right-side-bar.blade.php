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
                <img src="{{ $auth->image_url }}" class="rounded-circle" width="70" height="70" alt="">
{{--                <i class="fa fa-user fa-2x bg-primary text-white p-3 rounded-circle"></i>--}}
            </div>

            <h5><a href="{{ route('admins.profile') }}">{{ ucwords($auth->name) }}</a></h5>
            <p class="text-muted mb-0"><small>{{ ucwords($auth->role->name) }}</small></p>
        </div>
    </div>
</div>
