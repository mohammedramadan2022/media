@extends('Back.layouts.master')

@section('title', trans('back.home'))

@section('content')
    <div class="row mt-3">
        @foreach(getStatisticsCounters() as $model => $value)
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-model-count-element
                    :model="$model"
                    :icon="$value['icon']"
                    :count="$value['count']"
                    :color="$value['color']"
                    :soft="$value['is_soft']"
                ></x-model-count-element>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-xl-3">
            <x-morris-donut-chart :collection="$admin" model="admin" htmlID="admin-state"></x-morris-donut-chart>
        </div>
        <div class="col-xl-3">
            <x-morris-donut-chart :collection="$product" model="product" htmlID="product-state"></x-morris-donut-chart>
        </div>
        <div class="col-xl-3">
            <x-morris-donut-chart :collection="$user" model="user" htmlID="user-state"></x-morris-donut-chart>
        </div>
        <div class="col-xl-3">
            <div class="card-box" dir="rtl">
                <h4 class="header-title mt-0">{{ trans('back.orders.orders') }}</h4>

                @if($order['pending']->count() > 0 || $order['accepted']->count() > 0 || $order['rejected']->count() > 0 || $order['canceled']->count() > 0)
                    <div class="widget-chart text-center">
                        <div id="orders-donuts" dir="rtl" style="height: 350px;" class="morris-chart"></div>
                        <div class="text-center">
                            <p class="text-muted font-15 font-family-secondary mb-0">
                                <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-warning"></i>{{ trans('back.pending') }}</span>
                                <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-success"></i>{{ trans('back.accepted') }}</span>
                                <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-danger"></i>{{ trans('back.rejected') }}</span>
                                <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-purple"></i>{{ trans('back.processing') }}</span>
                                <span class="mx-2"><i class="mdi mdi-checkbox-blank-circle text-pink"></i>{{ trans('back.canceled') }}</span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center" style="margin-top: 320px;">@lang('back.no-value')</div>
                @endif
            </div>
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
                            <th>@lang('back.product-belongs-to')</th>
                            <th>@lang('back.since')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($latest_products as $key => $latest_product)
                            <tr id="product-row-{{ $latest_product->id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ ucwords($latest_product->name) }}</td>
                                <td>{!! $latest_product->owner_name !!}</td>
                                <td>{{ $latest_product->created_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    <a href="{{ route('products.show', $latest_product->id) }}" class="btn btn-xs btn-secondary">
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
            <div class="card-box" style="padding-bottom: 38px;">
                <h4 class="header-title mb-3">أحدث الطلبات</h4>

                <div class="table-responsive">
                    <table class="table table-borderless table-hover table-centered table-nowrap m-0">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>@lang('back.form-order-no')</th>
                            <th>@lang('back.form-total-without-tax')</th>
                            <th>@lang('back.form-subtotal')</th>
                            <th>@lang('back.form-order-total')</th>
                            <th>@lang('back.since')</th>
                            <th class="text-center">@lang('back.form-actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($latest_orders as $key => $latest_order)
                            <tr id="order-row-{{ $latest_order->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td><a href="{{ route('orders.show', $latest_order->id) }}">{!! highlightText($latest_order->order_no) !!}</a></td>
                                <td>{!! highlightText(money($latest_order->price)) !!}</td>
                                <td>{!! highlightText(money($latest_order->subtotal)) !!}</td>
                                <td>{!! highlightText(money($latest_order->total)) !!}</td>
                                <td>{{ $latest_order->since }}</td>
                                <td class="text-center">
                                    <a href="{{ route('orders.show', $latest_order->id) }}" class="btn btn-xs btn-secondary">
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

{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <h4 class="header-title">مخطط الأرباح الأسبوعي من عمليات الدفع الالكتروني</h4>--}}
{{--                    <div class="mt-4 chartjs-chart">--}}
{{--                        <canvas id="line-chart-example" height="350"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <h4 class="header-title">مخطط الأرباح الشهري من عمليات الدفع الالكتروني</h4>--}}

{{--                    <div class="mt-4 chartjs-chart">--}}
{{--                        <canvas id="bar-chart-example" height="350"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@stop

@section('scripts')
    {!! script('admin/libs/chart-js/Chart.bundle.min.js') !!}

    <script>
        $(document).ready(function(e){
            {{--new Chart($("#line-chart-example"), {--}}
            {{--    type: "line",--}}
            {{--    data: {--}}
            {{--        labels: [--}}
            {{--            "@lang('back.days.saturday')",--}}
            {{--            "@lang('back.days.sunday')",--}}
            {{--            "@lang('back.days.monday')",--}}
            {{--            "@lang('back.days.tuesday')",--}}
            {{--            "@lang('back.days.wednesday')",--}}
            {{--            "@lang('back.days.thursday')",--}}
            {{--            "@lang('back.days.friday')"--}}
            {{--        ],--}}
            {{--        datasets: [--}}
            {{--            {--}}
            {{--                label: "@lang('back.form-total')",--}}
            {{--                backgroundColor: "rgba(86, 194, 214, 0.3)",--}}
            {{--                borderColor: "#56c2d6",--}}
            {{--                data: @json($profits)--}}
            {{--            },--}}
            {{--        ],--}}
            {{--    },--}}
            {{--    options: {--}}
            {{--        maintainAspectRatio: !1,--}}
            {{--        legend: { display: !1 },--}}
            {{--        tooltips: { intersect: !1 },--}}
            {{--        hover: { intersect: !0 },--}}
            {{--        plugins: { filler: { propagate: !1 } },--}}
            {{--        scales: { xAxes: [{ reverse: !0, gridLines: { color: "rgba(0,0,0,0.05)" } }], yAxes: [{ ticks: { stepSize: 20 }, display: !0, borderDash: [5, 5], gridLines: { color: "rgba(0,0,0,0)", fontColor: "#fff" } }] },--}}
            {{--    }--}}
            {{--});--}}

            {{--new Chart($("#bar-chart-example"), {--}}
            {{--    type: "bar",--}}
            {{--    data: {--}}
            {{--        labels: [--}}
            {{--            "@lang('back.months.jan')",--}}
            {{--            "@lang('back.months.feb')",--}}
            {{--            "@lang('back.months.mar')",--}}
            {{--            "@lang('back.months.apr')",--}}
            {{--            "@lang('back.months.may')",--}}
            {{--            "@lang('back.months.jun')",--}}
            {{--            "@lang('back.months.jul')",--}}
            {{--            "@lang('back.months.aug')",--}}
            {{--            "@lang('back.months.sep')",--}}
            {{--            "@lang('back.months.oct')",--}}
            {{--            "@lang('back.months.nov')",--}}
            {{--            "@lang('back.months.dec')"--}}
            {{--        ],--}}
            {{--        datasets: [--}}
            {{--            {--}}
            {{--                label: "@lang('back.form-total')",--}}
            {{--                backgroundColor: "#f0643b",--}}
            {{--                borderColor: "#f0643b",--}}
            {{--                hoverBackgroundColor: "#f0643b",--}}
            {{--                hoverBorderColor: "#f0643b",--}}
            {{--                data: @json($barChart)--}}
            {{--            },--}}
            {{--        ],--}}
            {{--    },--}}
            {{--    options: {--}}
            {{--        maintainAspectRatio: !1,--}}
            {{--        legend: { display: !1 },--}}
            {{--        scales: { yAxes: [{ gridLines: { display: !1 }, stacked: !1, ticks: { stepSize: 20 } }], xAxes: [{ barPercentage: 0.7, categoryPercentage: 0.5, stacked: !1, gridLines: { color: "rgba(0,0,0,0.01)" } }] },--}}
            {{--    }--}}
            {{--});--}}

            Morris.Donut({
                element: "orders-donuts",
                data: [
                    { label: "{{ trans('back.pending') }}", value: {{ $order['pending']->count() }} },
                    { label: "{{ trans('back.accepted') }}", value: {{ $order['accepted']->count() }} },
                    { label: "{{ trans('back.rejected') }}", value: {{ $order['rejected']->count() }} },
                    { label: "{{ trans('back.processing') }}", value: {{ $order['processing']->count() }} },
                    { label: "{{ trans('back.canceled') }}", value: {{ $order['canceled']->count() }} },
                ],
                barSize: 0.2,
                resize: !0,
                colors: ["#f8cc6b", "#23b397", "#f0643b", "#675db7", "#e36498"]
            });
        });
    </script>

    @include('Back.includes.morrisDonutChart', [
        'htmlID'       => 'admin-state',
        'actives'      => $admin['active_admins']->count(),
        'deductives'   => $admin['deductive_admins']->count(),
    ])

    @include('Back.includes.morrisDonutChart', [
        'htmlID'       => 'product-state',
        'actives'      => $product['active_products']->count(),
        'deductives'   => $product['deductive_products']->count(),
    ])

    @include('Back.includes.morrisDonutChart', [
        'htmlID'       => 'user-state',
        'actives'      => $user['active_users']->count(),
        'deductives'   => $user['deductive_users']->count(),
    ])
@stop
