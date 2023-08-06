<a href="{{ route($route) }}" onclick="event.preventDefault();document.getElementById('logout-form-'{{ $id }}).submit();">
    <i class="icon-switch2"></i> @lang('backend.logout')
</a>

<form id="logout-form-{{ $id }}" action="{{ route($route) }}" method="POST" style="display: none;">
    @csrf
</form>