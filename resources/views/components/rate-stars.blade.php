@php
    $rate = rates()->getRate($rates ?? collect([]));
@endphp

@if(!empty($rate->avg))
    @for($i=1; $i <= 5; $i++)
        @if($rate->avg >= $i)
            <span class="orange mdi mdi-star f-25"></span>
        @else
            <span class="mdi mdi-star-outline f-25"></span>
        @endif
    @endfor
@else
    @for($i=1; $i <= 5; $i++)
        <span class="mdi mdi-star-outline f-25"></span>
    @endfor
@endif
<span class="f-25">({{ $rate->total }})</span>
