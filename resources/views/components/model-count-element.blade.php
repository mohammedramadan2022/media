@props(['color', 'icon' => 'fa fa-boxes', 'model', 'count', 'soft'])

<div class="card cta-box bg{{$soft ? '-soft' : ''}}-{{$color}}">
    <div class="card-body">
        <div class="media align-items-center">
            <div class="media-body">
                <h3 class="float-right {{$soft ? '' : 'text-white'}} border-bottom border{{$soft ? '-soft' : ''}}-{{$color}}">{{$count}}</h3>

                <div class="avatar-md bg-{{$color}} rounded-circle text-center mb-2">
                    <i class="{{$icon}} font-22 avatar-title text-light"></i>
                </div>

                <h5 class="font-weight-normal {{$soft ? '' : 'text-white'}} cta-box-title">@lang('back.' . plural($model) . '.' . plural($model))</h5>

                <small class="{{$soft ? '' : 'text-white'}}">اجمالى عدد @lang('back.' . plural($model) . '.' . plural($model))</small>

                <a href="{{ route(plural($model).'.index') }}" class="text-{{$soft ? $color : 'white'}} font-weight-bold float-right">
                    <span>عرض</span>&nbsp;<i class="fa fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>
