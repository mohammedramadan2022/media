<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">عام</li>

                <li><a href="{{ route('provider-panel') }}"><i class="fa fa-home"></i><span> @lang('back.dashboard') </span></a></li>
                <li><a href="{{ route('provider.products.index') }}"><i class="fa fa-shopping-bag"></i><span> @lang('back.products.products') </span></a></li>
                <li><a href="{{ route('provider.products.rental-products') }}"><i class="fa fa-shopping-cart"></i><span> @lang('back.rental-products') </span></a></li>
                <li><a href="{{ route('provider.orders.index') }}"><i class="fa fa-cart-arrow-down"></i><span> @lang('back.orders.orders') </span></a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
