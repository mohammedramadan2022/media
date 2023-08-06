@props(['model', 'icon', 'count' => null])

@if(has_permission(plural($model).'.index'))
    <li>
        <a href="{{ route(plural($model).'.index') }}">
            <i class="fa fa-{{ $icon }}"></i>
            @if($count)
                <x-menu-counter :counter="$count ?? null"></x-menu-counter>
            @endif
            <span> @lang('back.'.plural($model).'.'.plural($model)) </span>
        </a>
    </li>
@endif
