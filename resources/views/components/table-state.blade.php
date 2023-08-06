@props(['color', 'icon', 'slug', 'count'])

<div class="widget-rounded-circle bg-soft-{{$color}} rounded-0 card-box mb-0">
    <div class="row">
        <div class="col-6">
            <div class="avatar-lg rounded-circle bg-soft-{{ $color }}">
                <i class="fe-{{ $icon }} font-22 avatar-title text-{{ $color }}"></i>
            </div>
        </div>
        <div class="col-6">
            <div class="text-right">
                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ $count }}</span></h3>
                <p class="text-{{ $color }} mb-1 text-truncate">{{ trans('back.'.$slug) }}</p>
            </div>
        </div>
    </div>
</div>
