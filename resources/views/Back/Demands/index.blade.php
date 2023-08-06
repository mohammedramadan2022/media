@extends('Back.layouts.master')

@section('title', trans('back.demands.demands'))

@section('styles')
    {!! style('admin/libs/summernote/summernote-bs4.css') !!}
    {!! style('admin/libs/magnific-popup/magnific-popup.css') !!}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin-panel') }}">@lang('back.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('back.demands.demands')</li>
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
        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="primary" icon="tag" slug="form-total" :count="$demands->count()"></x-table-state>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="success" icon="check-circle" slug="watched" :count="$demands->where('is_accepted', 1)->count()"></x-table-state>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="danger" icon="clock" slug="new-messages" :count="$demands->where('is_accepted', 0)->count()"></x-table-state>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('includes.flash')
                <div class="card-body">
                    <h4 class="header-title">عرض {{ trans('back.demands.demands') }}</h4>
                    <div class="mb-1 mt-1">
                        <a href="{{ route('demands.export') }}" data-toggle="tooltip" title="@lang('back.export-csv')" class="btn btn-success @if($demands->count() == 0) disabled @endif"><i class="fa fa-file-excel"></i></a>
                        <a href="{{ route('demands.trashed') }}" data-toggle="tooltip" title="@lang('back.trashed')" class="btn btn-danger">
                            <i class="fa fa-trash-restore"></i>
                        </a>
                    </div>
                    <br>
                    <table class="table table-bordered dt-responsive nowrap no-footer dtr-inline f-16" id="demands">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-name')</th>
                            <th>@lang('back.form-identity')</th>
                            <th>@lang('back.form-phone')</th>
                            <th>@lang('back.form-email')</th>
                            <th>@lang('back.form-store-name')</th>
                            <th>@lang('back.form-logo')</th>
                            <th>@lang('back.accept-status')</th>
                            <th>@lang('back.since')</th>
                            <th>@lang('back.updated_at')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($demands as $key => $demand)
                            <tr id="demand-row-{{ $demand->id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{!! highlightText($demand->name) !!}</td>
                                <td>{!! highlightText($demand->identity) !!}</td>
                                <td>{!! highlightText($demand->phone) !!}</td>
                                <td>{!! highlightText($demand->email) !!}</td>
                                <td>{!! highlightText($demand->store_name) !!}</td>
                                <td><x-image-link :imageUrl="$demand->logo_url" width="80"></x-image-link></td>
                                <td>
                                    @if(is_null($demand->is_accepted) && $demand->is_active == 1)
                                        <a href="{{ route('demands.accept', $demand->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                                        <a href="{{ route('demands.reject', $demand->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                                    @elseif($demand->is_accepted == 1)
                                        <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                                    @elseif(is_null($demand->is_active) && is_null($demand->is_accepted))
                                        <span class="badge p-2 badge-warning">في انتظار تفعيل رَقَم الهاتف</span>
                                    @else
                                        <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                                    @endif
                                </td>
                                <td>{{ $demand->since }}</td>
                                <td>{{ $demand->last_update }}</td>
                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle btn btn-main-color m-1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-wrench"></i>&nbsp;&nbsp;<span>@lang('back.more')</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a class="dropdown-item" data-id="{{$demand->id}}" href="{{ route('demands.show', $demand->id) }}">
                                                @lang('back.show')
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a class="dropdown-item delete-action" data-id="{{$demand->id}}" href="{{ localeUrl('/admin-panel/demands/'.$demand->id) }}">
                                                @lang('back.delete')
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-table-alert-no-value></x-table-alert-no-value>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-name')</th>
                            <th>@lang('back.form-identity')</th>
                            <th>@lang('back.form-email')</th>
                            <th>@lang('back.form-store-name')</th>
                            <th>@lang('back.form-logo')</th>
                            <th>@lang('back.since')</th>
                            <th>@lang('back.updated_at')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div style="margin-right: auto;margin-left: auto;">
            {!! $demands->withQueryString()->links() !!}
        </div>
    </div>

    <div id="filter-modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-main-color">
                        <i class="fa fa-filter"></i>&nbsp;تصفية نتائج&nbsp;<span>(@lang('back.demands.demands'))</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-demands-search" action="{{ route('demands.search') }}" method="GET">
                    <div class="modal-body">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="term" value="{{ request('term') ?? ''  }}" class="form-control" placeholder="البحث">
                                </div>
                            </div>

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
                        <button type="submit" form="form-demands-search" class="btn btn-main-color waves-effect waves-light">تصفية النتائج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    {!! script('admin/libs/magnific-popup/jquery.magnific-popup.min.js') !!}
    {!! script('admin/js/pages/lightbox.init.js') !!}
    @include('Back.includes.deleteActionScript', ['model' => 'demand', 'deleteType' => 'force'])
@stop
