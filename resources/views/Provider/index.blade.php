@extends('Provider.layouts.master')

@section('title', trans('back.home'))

@section('content')
    <div class="row mt-3">
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="card cta-box bg-soft-primary">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h3 class="float-right border-bottom border-soft-primary">{{ $products_count }}</h3>

                            <div class="avatar-md bg-primary rounded-circle text-center mb-2">
                                <i class="fa fa-shopping-bag font-22 avatar-title text-light"></i>
                            </div>
                            <h5 class="font-weight-normal cta-box-title">@lang('back.products.products')</h5>
                            <small>إجمالي عدد @lang('back.products.products')</small>
                            <a href="{{ route('provider.products.index') }}" class="text-primary font-weight-bold float-right">
                                <span>عرض</span>&nbsp;<i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="card cta-box bg-soft-warning">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h3 class="float-right border-bottom border-soft-warning">{{ $rental_products_count }}</h3>

                            <div class="avatar-md bg-warning rounded-circle text-center mb-2">
                                <i class="fa fa-shopping-cart font-22 avatar-title text-light"></i>
                            </div>
                            <h5 class="font-weight-normal cta-box-title">@lang('back.rental-products')</h5>
                            <small>إجمالي عدد @lang('back.products.products')</small>
                            <a href="{{ route('provider.products.rental-products') }}" class="text-dark font-weight-bold float-right">
                                <span>عرض</span>&nbsp;<i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="card cta-box bg-soft-success">
                <div class="card-body">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h3 class="float-right border-bottom border-soft-success">{{ $orders_count }}</h3>

                            <div class="avatar-md bg-success rounded-circle text-center mb-2">
                                <i class="fa fa-cart-arrow-down font-22 avatar-title text-light"></i>
                            </div>
                            <h5 class="font-weight-normal cta-box-title">@lang('back.orders.orders')</h5>
                            <small>إجمالي عدد @lang('back.orders.orders')</small>
                            <a href="{{ route('provider.orders.index') }}" class="text-success font-weight-bold float-right">
                                <span>عرض</span>&nbsp;<i class="fa fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3">
{{--            <x-morris-donut-chart :collection="$admin" model="admin" htmlID="admin-state"></x-morris-donut-chart>--}}
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">أحدث المنتجات المضافة</h4>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover table-centered table-nowrap m-0">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-name')</th>
                            <th>@lang('back.since')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $key => $product)
                            <tr id="product-row-{{ $product->id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ ucwords($product->name) }}</td>
                                <td>{{ $product->created_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    <a href="{{ route('provider.products.show', $product->id) }}" class="btn btn-xs btn-secondary">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <x-table-alert-no-value></x-table-alert-no-value>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card-box">
                <h4 class="header-title mb-3">أحدث الطلبات</h4>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover table-centered table-nowrap m-0">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-order-no')</th>
                            <th>@lang('back.users.t-user')</th>
                            <th>@lang('back.form-subtotal')</th>
                            <th>@lang('back.form-order-total')</th>
                            <th>@lang('back.order-status')</th>
                            <th>@lang('back.since')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $key => $order)
                            <tr id="order-row-{{ $order->id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ $order->username }}</td>
                                <td>{{ money($order->pivot->provider_order_subtotal) }}</td>
                                <td>{{ money($order->pivot->provider_order_total) }}</td>
                                <td><x-order-status :order="$order"></x-order-status></td>
                                <td>{{ $order->since }}</td>
                                <td class="text-center">
                                    <a href="{{ route('provider.orders.show', $order->id) }}" class="btn btn-xs btn-secondary">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <x-table-alert-no-value></x-table-alert-no-value>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
