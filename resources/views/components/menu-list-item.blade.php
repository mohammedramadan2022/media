<li class="{{ $type == "" ? setActive('admin-panel/'.$models) : active($models.'.'.$type) }}">
    <a href="{{ localeUrl('/admin-panel/'.$models.'/'.$type) }}">
        @lang($trans)
    </a>
</li>
