<div>
    @if(!empty($rate))
        @for($i=1; $i <= 5; $i++)
            @if($rate >= $i)
                <span class="orange mdi mdi-star f-25"></span>
            @else
                <span class="mdi mdi-star-outline f-25"></span>
            @endif
        @endfor
        <span>({{$slot}})</span>
    @else
        @for($i=1; $i <= 5; $i++)
            <span class="mdi mdi-star-outline f-25"></span>
        @endfor
        <span>({{$slot}})</span>
    @endif
</div>
