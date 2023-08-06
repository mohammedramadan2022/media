@php use App\Enums\OrderStatus; @endphp

<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">عام</li>

                <li><a href="{{ route('admin-panel') }}"><i class="fa fa-home"></i><span> @lang('back.dashboard') </span></a></li>

                <x-side-bar-item model="contact" icon="envelope" :count="$newMessagesCount ?? null"></x-side-bar-item>
                <x-side-bar-item model="demand" icon="bullhorn" :count="$newDemandsCount ?? null"></x-side-bar-item>
                <x-side-bar-item model="vacation" icon="handshake" :count="$newVacationsCount ?? null"></x-side-bar-item>
                <x-side-bar-item model="advance" icon="hands-helping" :count="$newAdvancesCount ?? null"></x-side-bar-item>
                <x-side-bar-item model="throwback" icon="headset" :count="$newThrowbacksCount ?? null"></x-side-bar-item>
                <x-side-bar-item model="payment" icon="dollar-sign"></x-side-bar-item>

                @if(has_permission('admins.index', 'roles.index'))
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-user-secret"></i>
                            <span> @lang('back.administration') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('roles.index') }}"><span> @lang('back.roles.roles') </span></a></li>
                            <li><a href="{{ route('roles.create') }}"><span> @lang('back.create-var', ['var' => trans('back.roles.role')]) </span></a></li>
                            <li><a href="{{ route('admins.index') }}"><span> @lang('back.admins.admins') </span></a></li>
                            <li><a href="{{ route('admins.create') }}"><span> @lang('back.create-var', ['var' => trans('back.admins.admin')]) </span></a></li>
                        </ul>
                    </li>
                @endif

                @if(has_permission('users.index'))
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-users"></i>
                            <span> @lang('back.members') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('users.index') }}"><span> @lang('back.users.users') </span></a></li>
                            <li><a href="{{ route('users.create') }}"><span> @lang('back.create-var', ['var' => trans('back.users.user')]) </span></a></li>
                        </ul>
                    </li>
                @endif

                @if(has_permission('banners.index', 'previews.index', 'features.index'))
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-chalkboard"></i>
                            <span> @lang('back.sliders.sliders') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('banners.index') }}"><span> @lang('back.banners.banners') </span></a></li>
                            <li><a href="{{ route('previews.index') }}"><span> @lang('back.previews.previews') </span></a></li>
                            <li><a href="{{ route('features.index') }}"><span> @lang('back.features.features') </span></a></li>
                        </ul>
                    </li>
                @endif

                @if(has_permission('sections.index', 'categories.index'))
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-grip-horizontal"></i>
                            <span> @lang('back.sections.sections') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('sections.index') }}"><span> @lang('back.sections.sections') </span></a></li>
                            <li><a href="{{ route('sections.create') }}"><span> @lang('back.create-var', ['var' => trans('back.sections.section')]) </span></a></li>
                            <li><a href="{{ route('categories.index') }}"><span> @lang('back.categories.categories') </span></a></li>
                            <li><a href="{{ route('categories.create') }}"><span> @lang('back.create-var', ['var' => trans('back.categories.category')]) </span></a></li>
                        </ul>
                    </li>
                @endif

                <x-side-bar-menu-item model="order" icon="cart-arrow-down" customized="true">
                    <li><a href="{{ route('orders.index') }}"><span> @lang('back.all') </span></a></li>
                    <li>
                        <a href="{{ route('orders.types', OrderStatus::PENDING) }}">
                            <span> @lang('back.pending') </span>
                            <x-menu-counter :counter="$newOrdersCount ?? null"></x-menu-counter>
                        </a>
                    </li>
                    <li><a href="{{ route('orders.types', OrderStatus::REJECTED) }}"><span> @lang('back.rejected') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::CANCELED) }}"><span> @lang('back.canceled') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::ACCEPTED) }}"><span> @lang('back.accepted') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::PROCESSING) }}"><span> @lang('back.processing') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::DELIVERED) }}"><span> @lang('back.delivered') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::READY_FOR_DELIVERY) }}"><span> @lang('back.ready_for_delivery') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::IN_DELIVERY) }}"><span> @lang('back.in_delivery') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::RETRIEVING) }}"><span> @lang('back.retrieving') </span></a></li>
                    <li><a href="{{ route('orders.types', OrderStatus::REJECTED_BY_PROVIDER) }}"><span> @lang('back.rejected_by_provider') </span></a></li>
                    <li><a href="{{ route('orders.types', 'new') }}"><span> @lang('back.new') </span></a></li>
                </x-side-bar-menu-item>

                <x-side-bar-menu-item-count model="product" icon="shopping-cart" :count="$newProductsCount ?? null"></x-side-bar-menu-item-count>
                <x-side-bar-menu-item model="coupon" icon="money-bill-wave-alt"></x-side-bar-menu-item>
{{--                <x-side-bar-menu-item model="area" icon="university"></x-side-bar-menu-item>--}}
                <x-side-bar-menu-item model="city" icon="city"></x-side-bar-menu-item>
                <x-side-bar-menu-item model="provider" icon="users-cog"></x-side-bar-menu-item>
                <x-side-bar-menu-item model="human_resource" icon="book-reader"></x-side-bar-menu-item>
                <x-side-bar-menu-item model="course" icon="book"></x-side-bar-menu-item>
                <x-side-bar-menu-item model="vacation_type" icon="male"></x-side-bar-menu-item>
                <x-side-bar-menu-item model="spec" icon="check-square"></x-side-bar-menu-item>

                <li class="menu-title mt-2">@lang('back.settings.settings')</li>

                @if(has_permission('settings.index', 'subjects.index', 'faqs.index'))
                    <li>
                        <a href="javascript: void(0);">
                            <i class="fa fa-wrench"></i>
                            <span> @lang('back.general-settings') </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="{{ route('settings.index') }}"><span> @lang('back.settings.settings') </span></a></li>
                            <li><a href="{{ route('subjects.index') }}"><span> @lang('back.subjects.subjects') </span></a></li>
                            <li><a href="{{ route('faqs.index') }}"><span> @lang('back.faqs.faqs') </span></a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
