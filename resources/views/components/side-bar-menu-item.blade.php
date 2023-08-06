@props(['model', 'icon', 'customized' => 'false'])

@if(has_permission(plural_parts($model).'.index'))
    <li>
        <a href="javascript: void(0);">
            <i class="fa fa-{{ $icon }}"></i>
            <span> @lang('back.'.plural_parts($model).'.'.plural_parts($model)) </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            @if($customized == "true")
                {{ $slot }}
            @else
                <li>
                    <a href="{{ route(plural_parts($model).'.index') }}">
                        <span> @lang('back.all') </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route(plural_parts($model).'.create') }}">
                        <span> @lang('back.create-var', ['var' => trans('back.'.plural_parts($model).'.'.plural_parts($model)->singular())]) </span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
