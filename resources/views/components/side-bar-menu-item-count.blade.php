@props(['model', 'icon', 'count'])

@if(has_permission(plural_parts($model).'.index'))
    <li>
        <a href="javascript: void(0);">
            <i class="fa fa-{{ $icon }}"></i>
            <span> @lang('back.'.plural_parts($model).'.'.plural_parts($model)) </span>
            @if($count)
                <x-menu-counter :counter="$count"></x-menu-counter>
            @else
                <span class="menu-arrow"></span>
            @endif
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route(plural_parts($model).'.index') }}">
                    <span> @lang('back.all') </span>
                </a>
            </li>
            <li>
                <a href="{{ route(plural_parts($model).'.create') }}">
                    <span> @lang('back.create-var', ['var' => trans('back.'.plural_parts($model).'.'.$model)]) </span>
                </a>
            </li>
        </ul>
    </li>
@endif
