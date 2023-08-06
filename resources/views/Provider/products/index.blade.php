@extends('Provider.layouts.master')

@section('title', trans('back.products.products'))

@section('styles')
    {!! style('admin/libs/summernote/summernote-bs4.css') !!}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('provider-panel') }}">@lang('back.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('back.products.products')</li>
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
            <x-table-state color="primary" icon="tag" slug="form-total" :count="$products->count()"></x-table-state>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="success" icon="check-circle" slug="accepted" :count="$products->where('is_accepted', 1)->count()"></x-table-state>
        </div>

        <div class="col-sm-6 col-md-4 col-xl-4">
            <x-table-state color="danger" icon="clock" slug="pending" :count="$products->where('is_accepted', 0)->count()"></x-table-state>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('includes.flash')
                <div class="card-body">
                    <h4 class="header-title">عرض {{ trans('back.products.products') }}</h4>
                    <div class="mb-1 mt-1">
                        <a href="{{ route('provider.products.create') }}" data-toggle="tooltip" title="@lang('back.create-var', ['var' => trans('back.products.t-product')])" class="btn btn-main-color"><i class="fa fa-plus"></i></a>
                    </div>
                    <br>
                    <table class="table table-bordered dt-responsive nowrap no-footer dtr-inline f-16" id="products">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-name')</th>
                            <th>@lang('back.form-product-code')</th>
                            <th>@lang('back.form-quantity')</th>
                            <th>@lang('back.accept-status')</th>
                            <th>@lang('back.since')</th>
                            <th>@lang('back.updated_at')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $key => $product)
                            <tr id="product-row-{{ $product->id }}">
                                <td>{{ $key+1 }}</td>
                                <td data-toggle="tooltip" title="{{ $product->name }}">{!! highlightText($product->name) !!}</td>
                                <td>{!! highlightText($product->code) !!}</td>
                                <td>{!! highlightText($product->qty) !!}</td>
                                <td>
                                    @if($product->is_accepted)
                                        <label class="badge badge-success p-2 display-block f-12">@lang('back.accepted') <i class="fa fa-check-circle"></i></label>
                                    @else
                                        <label class="badge badge-warning p-2 display-block f-12">@lang('back.pending') <i class="fa fa-clock"></i></label>
                                    @endif
                                </td>
                                <td>{{ $product->since }}</td>
                                <td>{{ $product->last_update }}</td>
                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle btn btn-main-color m-1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-wrench"></i>&nbsp;&nbsp;<span>@lang('back.more')</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a class="dropdown-item message-details-btn" data-id="{{$product->id}}" href="{{ route('provider.products.show', $product->id) }}">
                                                @lang('back.show')
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a class="dropdown-item" href="{{ route('provider.products.edit', $product->id) }}">
                                                تعديل&nbsp;&nbsp;<i class="fa fa-edit"></i>
                                            </a>

                                            <a class="dropdown-item delete-action" data-id="{{$product->id}}" href="{{ localeUrl('/provider-panel/products/'.$product->id) }}">
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
                            <th>@lang('back.form-subject')</th>
                            <th>@lang('back.form-email')</th>
                            <th>@lang('back.type')</th>
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
            {!! $products->withQueryString()->links() !!}
        </div>
    </div>

    <div id="filter-modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-main-color">
                        <i class="fa fa-filter"></i>&nbsp;تصفية نتائج&nbsp;<span>(@lang('back.products.products'))</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-products-search" action="{{ route('products.search') }}" method="GET">
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
                        <button type="submit" form="form-products-search" class="btn btn-main-color waves-effect waves-light">تصفية النتائج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @include('Back.includes.deleteActionScript', ['model' => 'product', 'deleteType' => 'force'])
@stop
