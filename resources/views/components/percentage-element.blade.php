@props(['value', 'fgColor' => '#50552dd1', 'bgColor' => '#8C9173'])

<div class="widget-chart-1">
    <div class="widget-chart-box-1" dir="ltr">
        <input data-plugin="knob"
               data-width="80"
               data-height="80"
               data-fgColor="{{ $fgColor }}"
               data-bgColor="{{ $bgColor }}" value="{{ $value }}"
               data-skin="tron"
               data-angleOffset="180"
               data-readOnly=true
               data-thickness=".15"/>
    </div>
</div>
