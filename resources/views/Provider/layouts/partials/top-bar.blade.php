<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a href="{{ route('provider.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form-0').submit();" class="nav-link dropdown-toggle">
                <span>@lang('back.logout')</span>&nbsp;<i class="fe-log-out"></i>
            </a>
            <form id="logout-form-0" action="{{ route('provider.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>

        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ route('provider-panel') }}" class="logo text-center">
            <span class="logo-lg"><img src="{{ main_logo_url() }}" alt="" height="60"></span>
            <span class="logo-sm"><img src="{{ asset_url('admin/images/favicon.png') }}" alt="" height="30"></span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </li>

        <li class="d-none d-sm-block">
            <form class="app-search" action="{{ route('search') }}" method="GET">
                <div class="app-search-box">
                    <div class="input-group">
                        <select class="form-control" name="model_name">
                            <option value="" selected="">اختر نوع البحث ...</option>
                        </select>

                        <input type="text" name="search" value="{{ request('search') ?? '' }}" class="form-control top-search-input" placeholder="ابحث هنا ...">

                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li>
    </ul>
</div>
