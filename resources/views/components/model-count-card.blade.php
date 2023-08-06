<div class="card cta-box bg-{{$color}}">
    <div class="card-body">
        <div class="media align-items-center">
            <div class="media-body">
                <h3 class="float-right border-bottom border-{{$color}}">{{$collection->count()}}</h3>

                <div class="avatar-md bg-info rounded-circle text-center mb-2">
                    <i class="fa fa-boxes font-22 avatar-title text-light"></i>
                </div>
                <h5 class="font-weight-normal cta-box-title">@lang('back.' . plural($model) . '.' . plural($model))</h5>
                <small>اجمالى عدد @lang('back.' . plural($model) . '.' . plural($model))</small>
                <a href="#" class="text-{{$color}} font-weight-bold float-right"><span>عرض</span>&nbsp;<i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
    </div>
</div>
