@extends(ucfirst($nameSpace).'.layouts.master')

@section('title', $title)

@section('styles')
    {!! style('admin/libs/datatables/dataTables.bootstrap4.css') !!}
    {!! style('admin/libs/datatables/responsive.bootstrap4.css') !!}
    {!! style('admin/libs/jquery-toast/jquery.toast.min.css') !!}
    {!! style('admin/libs/sweetalert2/sweetalert2.min.css') !!}
    {!! style('admin/libs/magnific-popup/magnific-popup.css') !!}
    {!! style('admin/libs/select2/select2.min.css') !!}
@stop

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if($nameSpace == 'provider')
                    <li class="breadcrumb-item"><a href="{{ route('provider-panel') }}">@lang('back.dashboard')</a></li>
                    @if($model != 'video')
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ route('provider.'.plural($model).'.index') }}">
                                @lang('back.'.plural($model).'.'.plural($model))
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ url()->previous() }} ">
                                @lang('back.courses.t-course')
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
                    @if($model != 'video')
                        @if($model == 'doctor')
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route(plural($model).'.active') }}">
                                    @lang('back.'.plural($model).'.'.plural($model))
                                </a>
                            </li>
                        @elseif($model == 'media')
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('media.index') }}">
                                    @lang('back.medias.medias')
                                </a>
                            </li>
                        @elseif($model == 'setting')
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route('settings.configurations') }}">
                                    @lang('back.settings.settings')
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="{{ route(plural($model).'.index') }}">
                                    @lang('back.'.plural($model).'.'.plural($model))
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="breadcrumb-item" aria-current="page">
                            <a href="{{ url()->previous() }} ">
                                @lang('back.courses.t-course')
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                @endif
            </ol>
        </nav>
        <div class="row">
            {{ $slot }}
        </div>
    </div>
@stop
@section('scripts')
    {!! script('admin/libs/datatables/jquery.dataTables.min.js') !!}
    {!! script('admin/libs/datatables/dataTables.bootstrap4.js') !!}
    {!! script('admin/libs/datatables/dataTables.responsive.min.js') !!}
    {!! script('admin/libs/datatables/dataTables.buttons.min.js') !!}
    {!! script('admin/libs/datatables/buttons.print.min.js') !!}
    {!! script('admin/libs/magnific-popup/jquery.magnific-popup.min.js') !!}
    {!! script('admin/js/pages/lightbox.init.js') !!}

    @includeWhen(!changeStatusNotIn($model), 'Back.includes.isChecked', ['model' => $model])

    {{ $scripts ?? '' }}
@stop
