@php use App\Enums\OrderStatus; use App\Enums\PaymentEnum; @endphp

<x-show-element-layout :title="$order->order_no" model="order" nameSpace="back">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a href="#order" data-toggle="tab" aria-expanded="false" class="nav-link active">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">@lang('back.orders.t-order')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#user" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.users.t-user')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#products" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.products.products') ({{ $order->products()->count() }})</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#order-status" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.order-statuses')</span>
            </a>
        </li>
        @if($order->providers()->count() > 0)
            <li class="nav-item">
                <a href="#providers" data-toggle="tab" aria-expanded="false" class="nav-link">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">@lang('back.providers.providers') ({{ $order->providers()->count() }})</span>
                </a>
            </li>
        @endif
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="order">
            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-order-no')</h4>
                                <h5>{{ $order->order_no ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-total-without-tax')</h4>
                                <h5>{{ money($order->price) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-tax')</h4>
                                <h5>{{ money($order->tax) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-subtotal')</h4>
                                <h5>{{ money($order->subtotal) ?? trans('back.no-value') }}</h5>
                            </li>

                            @if($order->discount)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.discount')</h4>
                                    <h5>{{ money($order->discount) ?? trans('back.no-value') }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-with-coupon')</h4>
                                    <h5>{{ $order->coupon ?? trans('back.no-value') }}</h5>
                                </li>
                            @endif

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-order-total')</h4>
                                <h5>{{ money($order->total) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.invoice')</h4>
                                <a href="{{ $order->invoice_url }}" target="_blank" class="btn btn-main-color">@lang('back.invoice')</a>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.order-status')</h4>
                                <x-order-status :order="$order"></x-order-status>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.delivery-type')</h4>
                                <h5>{{ trans('back.' . $order->delivery_type) ?? trans('back.no-value') }}</h5>
                            </li>

                            @if($order->is_all_accept && $order->status == OrderStatus::PENDING && $order->final_accept == 0)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.final-accept')</h4>
                                    <a class="btn btn-outline-success"
                                       href="{{ route('orders.final-accept', $order->id) }}">
                                        @lang('back.order-final-accept')
                                    </a>
                                </li>
                            @endif

                            @if($order->addresses()->count() > 0)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.delivery-address')</h4>
                                    <ul class="list-group">
                                        @foreach($order->addresses as $address)
                                            <li class="list-group-item">
                                                <h5># {{ $address->address ?? trans('back.no-value') }}</h5>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif

                            @if($order->is_delay_paid == PaymentEnum::NEW_DELAY_CASH && $order->delay_penalty > 0)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.confirm-delay-cash-paid')</h4>
                                    <a class="btn btn-outline-success" href="{{ route('orders.delay-cash-paid', ['order' => $order->id, 'type' => 'accept']) }}">
                                        @lang('back.confirm')
                                    </a>
                                    <a class="btn btn-outline-danger" href="{{ route('orders.delay-cash-paid', ['order' => $order->id, 'type' => 'reject']) }}">
                                        @lang('back.refuse')
                                    </a>
                                </li>
                            @endif

                            <li class="list-group-item">
                                @if(is_null($order->payment_id) && $order->payment_method == PaymentEnum::CASH)
                                    <h4 class="text-muted">@lang('back.confirm-cash-paid')</h4>
                                @else
                                    <h4 class="text-muted">@lang('back.payment-status')</h4>
                                @endif
                                <x-order-payment-status :order="$order"></x-order-payment-status>
                            </li>

                            <li class="list-group-item">
                                <div class="pull-right">
                                    <h4 class="text-muted">@lang('back.form-start-date')</h4>
                                    <h5>{{ $order->start_date->format('Y-m-d') ?? trans('back.no-value') }}</h5>
                                </div>
                                <div class="pull-left">
                                    <h4 class="text-muted">@lang('back.form-start-time')</h4>
                                    <h5>{{ $order->start_time->format('h:i A') ?? trans('back.no-value') }}</h5>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="pull-right">
                                    <h4 class="text-muted">@lang('back.form-end-date')</h4>
                                    <h5>{{ $order->end_date->format('Y-m-d') ?? trans('back.no-value') }}</h5>
                                </div>
                                <div class="pull-left">
                                    <h4 class="text-muted">@lang('back.form-end-time')</h4>
                                    <h5>{{ $order->end_time->format('h:i A') ?? trans('back.no-value') }}</h5>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.cities.t-city')</h4>
                                <h5>{{ $order->user->city->name ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $order->since }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="user">
            <div class="row">
                <div class="col-md-12">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.users.t-user')</h4>
                                <a href="{{ route('users.show', $order->user_id) }}" style="font-weight: bold;font-size: 16px;">
                                    {{ $order->username ?? trans('back.no-value') }}
                                </a>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-identity-image')</h4>
                                <a href="{{ $order->user->identity_image_url }}" class="image-popup-vertical-fit">
                                    <img class="card-img-top img-fluid" src="{{ $order->user->identity_image_url }}" style="width: 23%" alt="image">
                                </a>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-email')</h4>
                                <h5>{{ $order->user->email ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-phone')</h4>
                                <h5>{{ $order->user->phone ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-identity')</h4>
                                <h5>{{ $order->user->identity_number ?? trans('back.no-value') }}</h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="products">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.products.t-product')</th>
                    <th>@lang('back.ownership')</th>
                    <th>@lang('back.form-image')</th>
                    <th>@lang('back.form-price')</th>
                    <th>@lang('back.form-offer-value')</th>
                    <th>@lang('back.form-quantity')</th>
                    <th>@lang('back.form-required-quantity')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->products as $i => $product)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td><a href="{{ route('products.show', $product->id) }}">{{ ucwords($product->pivot->product_name) }}</a></td>
                        <td>{!! $product->owner_name !!}</td>
                        <td><x-image-link :imageUrl="$product->first_image_url" width="50"></x-image-link></td>
                        <td>{{ money($product->pivot->product_price) }}</td>
                        <td>
                            @if($product->offer)
                                <span class="badge badge-warning p-2 f-12 display-block text-dark">{{ money($product->pivot->product_offer) }}</span>
                            @else
                                <span class="badge badge-light-dark p-2 display-block">@lang('back.no-value')</span>
                            @endif
                        </td>
                        <td><span class="badge badge-danger p-2 display-block">{{ $product->qty }}</span></td>
                        <td><span class="badge badge-info p-2 display-block">{{ $product->pivot->product_qty }}</span></td>
                        <td>{{ $product->since }}</td>
                        <td>{{ $product->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.products.t-product')</th>
                    <th>@lang('back.ownership')</th>
                    <th>@lang('back.form-image')</th>
                    <th>@lang('back.form-price')</th>
                    <th>@lang('back.form-offer-value')</th>
                    <th>@lang('back.form-quantity')</th>
                    <th>@lang('back.form-required-quantity')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="providers">
            <table class="table text-center">
                <thead>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-name')</th>
                    <th>@lang('back.accept-status')</th>
                    <th>@lang('back.order-created-at')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->providers as $i => $provider)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td><a href="{{ route('providers.show', $provider->id) }}">{{ ucwords($provider->name) }}</a>
                        </td>
                        <td>
                            @if($provider->pivot->is_accepted == 0)
                                <a href="{{ route('orders.reject-provider-order', ['provider' => $provider->id, 'order' => $order->id]) }}"
                                   class="btn btn-danger">@lang('back.reject')</a>
                            @elseif($provider->pivot->is_accepted == 1)
                                <span class="badge badge-success p-2 text-center">@lang('back.accepted')</span>
                            @elseif($provider->pivot->is_accepted == 2)
                                <span class="badge badge-success p-2 text-center">@lang('back.rejected')</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>{{ $provider->last_update }}</td>
                    </tr>
                @empty
                    <x-table-alert-no-value></x-table-alert-no-value>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th scope="row">#</th>
                    <th>@lang('back.form-name')</th>
                    <th>@lang('back.accept-status')</th>
                    <th>@lang('back.order-created-at')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="order-status">
            <form action="{{ route('orders.change-order-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="form-group">
                    <x-form.select-input :arr="$statuses" name="order_status" slug="form-status"></x-form.select-input>
                </div>

                <button type="submit" class="btn btn-main-color">@lang('back.change')</button>
            </form>
        </div>
    </div>
    <x-slot name="scripts">
        @include('Back.includes.showModelScript', ['class' => 'send-admin-message', 'modelId' => 'view_show_order_payment_process'])
        <script>
            $(document).ready(function () {
                $('select#order_status').on('change', async function (e) {
                    e.preventDefault();

                    $.ajax({
                        method: 'POST',
                        url: '{{ route('orders.ajax-is-order-accepted', $order->id) }}',
                        data: {status: $(this).val()},
                        success: async ({is_payed}) => {
                            if (is_payed === true) await setOrderPayed();
                        },
                        error: err => crud_handle_server_errors(err),
                    });

                    if ($(this).val() === '{{ OrderStatus::READY_FOR_DELIVERY }}') {
                        $.ajax({
                            type: 'GET',
                            url: '{{ route('orders.show-order-provider-modal', ['order_id' => $order->id]) }}',
                            success: response => showModal(response, 'view_show_order_provider'),
                            error: x => crud_handle_server_errors(x)
                        });
                    }
                });

                async function setOrderPayed() {
                    let isConfirmed = await swal({
                        title: 'تنبيه',
                        text: 'عفوا هذا الطلب غير مدفوع هل تود إكمال عملية الدفع او انتظار العميل لحين دفع قيمة الطلب ؟',
                        icon: "warning",
                        buttons: ["إلغاء", "متأكد"],
                        dangerMode: true
                    });

                    if (isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: '{{ route('orders.show-order-payment-process', ['order_id' => $order->id]) }}',
                            success: response => showModal(response, 'view_show_order_payment_process'),
                            error: x => crud_handle_server_errors(x)
                        });
                    }
                }
            });
        </script>
    </x-slot>
</x-show-element-layout>
