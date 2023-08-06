@extends('Provider.layouts.master')

@section('title', trans('back.orders.orders'))

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
                        <li class="breadcrumb-item active" aria-current="page">@lang('back.orders.orders')</li>
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
            <x-table-state color="primary" icon="tag" slug="form-total" :count="$orders->count()"></x-table-state>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('includes.flash')
                <div class="card-body">
                    <h4 class="header-title">عرض {{ trans('back.orders.orders') }}</h4>
                    <br>
                    <table class="table table-bordered dt-responsive nowrap no-footer dtr-inline f-16" id="orders">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-order-no')</th>
                            <th>@lang('back.users.t-user')</th>
                            <th>@lang('back.form-subtotal')</th>
                            <th>@lang('back.discount')</th>
                            <th>@lang('back.form-order-total')</th>
                            <th>@lang('back.accept-status')</th>
                            <th>@lang('back.order-status')</th>
                            <th>@lang('back.since')</th>
                            <th>@lang('back.updated_at')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $key => $order)
                            <tr id="order-row-{{ $order->id }}">
                                <td style="padding-top: 30px;">{{ $key+1 }}</td>
                                <td style="padding-top: 30px;">{!! highlightText($order->order_no) !!}</td>
                                <td style="padding-top: 30px;">{!! highlightText($order->username) !!}</td>
                                <td style="padding-top: 30px;">{!! highlightText(money($order->pivot->provider_order_subtotal)) !!}</td>
                                <td style="padding-top: 30px;">{!! highlightText(money($order->pivot->provider_order_discount)) !!}</td>
                                <td style="padding-top: 30px;">{!! highlightText(money($order->pivot->provider_order_total)) !!}</td>
                                <td>
                                    @if($order->pivot->is_accepted == 0)
                                        <a href="{{ route('provider.orders.accept', $order->id) }}" class="btn btn-outline-success">@lang('back.accept')</a>
                                        <a href="{{ route('provider.orders.reject', $order->id) }}" class="btn btn-outline-danger">@lang('back.refuse')</a>
                                    @elseif($order->pivot->is_accepted == 2)
                                        <span class="badge p-2 badge-danger">@lang('back.refused')</span>
                                    @else
                                        <span class="badge p-2 badge-success">@lang('back.accepted')</span>
                                    @endif
                                </td>
                                <td><x-order-status :order="$order"></x-order-status></td>
                                <td style="padding-top: 30px;">{{ $order->since }}</td>
                                <td style="padding-top: 30px;">{{ $order->last_update }}</td>
                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle btn btn-main-color m-1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-wrench"></i>&nbsp;&nbsp;<span>@lang('back.more')</span>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a class="dropdown-item message-details-btn" data-id="{{$order->id}}" href="{{ route('provider.orders.show', $order->id) }}">
                                                @lang('back.show')
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a class="dropdown-item delete-action" data-id="{{$order->id}}" href="{{ localeUrl('/provider-panel/orders/'.$order->id) }}">
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
                            <th>@lang('back.form-order-no')</th>
                            <th>@lang('back.users.t-user')</th>
                            <th>@lang('back.form-subtotal')</th>
                            <th>@lang('back.discount')</th>
                            <th>@lang('back.form-order-total')</th>
                            <th>@lang('back.accept-status')</th>
                            <th>@lang('back.order-status')</th>
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
            {!! $orders->withQueryString()->links() !!}
        </div>
    </div>

    <div id="filter-modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-main-color">
                        <i class="fa fa-filter"></i>&nbsp;تصفية نتائج&nbsp;<span>(@lang('back.orders.orders'))</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="form-orders-search" action="{{ route('provider.orders.search') }}" method="GET">
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
                        <button type="submit" form="form-orders-search" class="btn btn-main-color waves-effect waves-light">تصفية النتائج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @include('Back.includes.deleteActionScript', ['model' => 'product', 'deleteType' => 'force'])
@stop
