<x-show-element-layout :title="$order->order->order_no" model="order" nameSpace="provider">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a href="#order" data-toggle="tab" aria-expanded="false" class="nav-link active">
                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                <span class="d-none d-sm-block">@lang('back.orders.t-order')</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#products" data-toggle="tab" aria-expanded="false" class="nav-link">
                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                <span class="d-none d-sm-block">@lang('back.products.products') ({{ $order->order->products->where('type', 'App\Models\Provider')->where('type_id', auth()->guard('provider')->id())->count() }})</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="order">
            <div class="row">
                <div class="col-md-12">
                    <div class="well">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-order-no')</h4>
                                <h5>{{ $order->order->order_no ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.users.t-user')</h4>
                                <a href="{{ route('users.show', $order->order->user_id) }}" style="font-weight: bold;font-size: 16px;">
                                    {{ $order->order->username ?? trans('back.no-value') }}
                                </a>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-total-without-tax')</h4>
                                <h5>{{ money($order->provider_order_price) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-tax')</h4>
                                <h5>{{ money($order->provider_order_tax) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-subtotal')</h4>
                                <h5>{{ money($order->provider_order_subtotal) ?? trans('back.no-value') }}</h5>
                            </li>

                            @if($order->provider_order_discount)
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.discount')</h4>
                                    <h5>{{ money($order->provider_order_discount) ?? trans('back.no-value') }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-with-coupon')</h4>
                                    <h5>{{ $order->order->coupon ?? trans('back.no-value') }}</h5>
                                </li>
                            @endif

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.form-order-total')</h4>
                                <h5>{{ money($order->provider_order_total) ?? trans('back.no-value') }}</h5>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.order-status')</h4>
                                <x-order-status :order="$order"></x-order-status>
                            </li>

                            <li class="list-group-item">
                                <h4 class="text-muted">@lang('back.since')</h4>
                                <h5>{{ $order->order->since }}</h5>
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
                    <th>@lang('back.form-name')</th>
                    <th>@lang('back.form-image')</th>
                    <th>@lang('back.form-price')</th>
                    <th>@lang('back.form-offer-value')</th>
                    <th>@lang('back.form-quantity')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->order->products->where('type', 'App\Models\Provider')->where('type_id', auth()->guard('provider')->id()) as $i => $product)
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <td><a href="{{ route('provider.products.show', $product->id) }}">{{ ucwords($product->name) }}</a></td>
                        <td><x-image-link :imageUrl="$product->first_image_url" width="60"></x-image-link></td>
                        <td>{{ money($product->price) }}</td>
                        <td>
                            <span class="badge badge-light-dark p-2 display-block">
                                {{ $product->offer ? $product->offer_value : trans('back.no-value') }}
                            </span>
                        </td>
                        <td>{{ $product->pivot->product_qty }}</td>
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
                    <th>@lang('back.form-name')</th>
                    <th>@lang('back.form-image')</th>
                    <th>@lang('back.form-price')</th>
                    <th>@lang('back.form-offer-value')</th>
                    <th>@lang('back.form-quantity')</th>
                    <th>@lang('back.since')</th>
                    <th>@lang('back.updated_at')</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-show-element-layout>
