@props(['counter'])

@if($counter)
    <span class="badge badge-danger float-right">{{ $counter }}</span>
@endif
