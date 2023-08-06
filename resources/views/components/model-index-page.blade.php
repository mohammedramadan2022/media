@props(['model', 'collection'])

<x-back-layout :model="$model" :collection="$collection">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ checkUrlHas('provider-panel') ? route('provider-panel') : route('admin-panel') }}">@lang('back.dashboard')</a></li>
                        @if(isset($breadcrumb))
                            @if($model == 'provider')
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="{{ route("$plural.active") }}">
                                        @lang('back.'.plural_parts($model).'.'.plural_parts($model))
                                    </a>
                                </li>
                            @else
                                <li class="breadcrumb-item" aria-current="page">
                                    <a href="{{ checkUrlHas('provider-panel') ? route('provider'.plural_parts($model).'.index') : route(plural_parts($model).'.index') }}">
                                        @lang('back.'.plural_parts($model).'.'.plural_parts($model))
                                    </a>
                                </li>
                            @endif
                            {{ $breadcrumb ?? '' }}
                        @else
                            <li class="breadcrumb-item active" aria-current="page">@lang('back.'.plural_parts($model).'.'.plural_parts($model))</li>
                        @endif
                    </ol>
                </div>

                <div class="page-title">
                    <button type="button" class="btn btn-main-color waves-effect waves-info" data-toggle="modal" data-target="#filter-modal">
                        <i class="fa fa-filter"></i>&nbsp;تصفية النتائج
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-gutters">
        @if(isset($tableState))
            {{ $tableState ?? '' }}
        @else
            @if($collection)
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <x-table-state color="primary" icon="tag" slug="form-total" :count="(int)$collection->total() + (int)getModelCount($model === 'provider' ? 'user' : $model, true)"></x-table-state>
                </div>
            @endif
            @if($collection && !no_status_collections($model))
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <x-table-state color="success" icon="check-circle" slug="actives" :count="$collection->where('status', 1)->count()"></x-table-state>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <x-table-state color="danger" icon="clock" slug="deductives" :count="$collection->where('status', 0)->count()"></x-table-state>
                </div>
            @endif
            @if(checkIfTableSoftDeleted($model))
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <x-table-state color="warning" icon="trash-2" slug="deleteds" :count="getModelCount($model === 'provider' ? 'user' : $model, true)"></x-table-state>
                </div>
            @endif
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('includes.flash')
                    <h4 class="header-title">عرض {{ trans('back.'.plural_parts($model).'.'.plural_parts($model)) }}</h4>

                    <div class="mb-1 mt-1">
                        @if(!in_array($model, creatRouteNotIn()))
                            <a data-toggle="tooltip" title="{{ transCreate($model) }}" href="{{ route(plural_parts($model).'.create') }}" class="btn btn-primary">+</a>
                        @endif

                        @if(!in_array($model, trashedRouteNotIn()))
                            <a href="{{ route(plural_parts($model).'.trashed') }}" data-toggle="tooltip" title="@lang('back.trashed')" class="btn btn-danger">
                                <i class="fa fa-trash-restore"></i>
                            </a>
                        @endif

                        <a href="{{ route(plural_parts($model).'.export') }}" data-toggle="tooltip" title="@lang('back.export-csv')" class="btn @if($collection->total() == 0) disabled @endif btn-success">
                            <i class="fa fa-file-excel"></i>
                        </a>

                        {{ $buttons ?? '' }}
                    </div>

                    <br>

                    <table id="{{plural_parts($model)}}-datatable" class="table table-hover dt-responsive nowrap text-center">
                        <thead>
                        {{ $thead ?? '' }}
                        </thead>
                        <tbody>
                        {{ $slot }}
                        </tbody>
                        <tfoot>
                        {{ $thead ?? '' }}
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @if($collection instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div style="margin-right: auto;margin-left: auto;">
                {!! $collection->withQueryString()->links() !!}
            </div>
        @endif
    </div>

    <div id="filter-modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-main-color">
                        <i class="fa fa-filter"></i>&nbsp;تصفية نتائج&nbsp;<span>( {{ trans('back.'.plural_parts($model).'.'.plural_parts($model)) }} )</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-{{plural_parts($model)}}-search" action="{{ checkUrlHas('provider-panel') ? route('provider.'.plural_parts($model).'.search') : route(plural_parts($model).'.search') }}" method="GET">
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="term" value="{{ request('term') ?? ''  }}" class="form-control" placeholder="البحث">
                                </div>
                            </div>

                            {{ $filter ?? '' }}

                            <div class="col-md-12">
                                <div class="radio radio-main-color form-check-inline">
                                    <input type="radio" id="newer-to-older" value="newer-to-older" name="sorting" {{ request()->has('sorting') ? (request('sorting') == 'newer-to-older' ? 'checked' : '') : 'checked' }}>
                                    <label for="newer-to-older">من الأحدث للأقدم</label>
                                </div>
                                <div class="radio radio-main-color form-check-inline">
                                    <input type="radio" id="older-to-newer" value="older-to-newer" name="sorting" {{ request()->has('sorting') ? (request('sorting') == 'older-to-newer' ? 'checked' : '') : '' }}>
                                    <label for="older-to-newer">من الأقدم للأحدث</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="form-{{plural_parts($model)}}-search" class="btn btn-main-color waves-effect waves-light">تصفية النتائج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        {{ $scripts ?? '' }}
    </x-slot>
</x-back-layout>
