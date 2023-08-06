@php use App\Enums\OrderStatus; @endphp

<x-model-index-page model="order" :collection="$orders">
    <x-slot name="tableState">
        @if(!Route::is('orders.types'))
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="primary" icon="tag" slug="form-total" :count="(int)$orders->total() + (int)getModelCount('order', true)"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="warning" icon="clock" slug="pending" :count="$orders->where('status', OrderStatus::PENDING)->where('is_rental_accept', 1)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="danger" icon="x" slug="rejected" :count="$orders->where('status', OrderStatus::REJECTED)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="purple" icon="check-circle" slug="processing" :count="$orders->where('status', OrderStatus::PROCESSING)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="warning" icon="info" slug="new" :count="$orders->where('status', OrderStatus::PENDING)->where('is_rental_accept', 0)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="secondary" icon="trash" slug="canceled" :count="$orders->where('status', OrderStatus::CANCELED)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="success" icon="check" slug="accepted" :count="$orders->where('status', OrderStatus::ACCEPTED)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="pink" icon="navigation" slug="ready_for_delivery" :count="$orders->where('status', OrderStatus::READY_FOR_DELIVERY)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="dark" icon="map" slug="ready_for_pick_up" :count="$orders->where('status', OrderStatus::PICK_UP)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="info" icon="navigation-2" slug="in_delivery" :count="$orders->where('status', OrderStatus::IN_DELIVERY)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="primary" icon="thumbs-up" slug="received" :count="$orders->where('status', OrderStatus::RECEIVED)->count()"></x-table-state>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <x-table-state color="success" icon="pocket" slug="delivered" :count="$orders->where('status', OrderStatus::DELIVERED)->count()"></x-table-state>
            </div>
        @endif
    </x-slot>
    <x-slot name="thead">
        <tr>
            <th>#</th>
            <th>@lang('back.form-order-no')</th>
            <th>@lang('back.users.t-user')</th>
            <th>@lang('back.form-total-without-tax')</th>
            <th>@lang('back.form-subtotal')</th>
            <th>@lang('back.form-order-total')</th>
            <th>@lang('back.payment-status')</th>
            @if(!Route::is('orders.types'))<th>@lang('back.form-status')</th>@endif
            <th>@lang('back.since')</th>
            <th class="text-center">@lang('back.form-actions')</th>
        </tr>
    </x-slot>
    @foreach($orders as $i => $order)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{!! highlightText($order->order_no) !!}</td>
            <td>
                @if($order->user_id)
                    <a href="{{ route('users.show', $order->user_id) }}">{!! highlightText($order->username) !!}</a>
                @else
                    {!! highlightText($order->username) !!}
                @endif
            </td>
            <td>{!! highlightText(money($order->price)) !!}</td>
            <td>{!! highlightText(money($order->subtotal)) !!}</td>
            <td>{!! highlightText(money($order->total)) !!}</td>
            <td><x-order-payment-status :order="$order"></x-order-payment-status></td>
            @if(!Route::is('orders.types'))
                <td><x-order-status :order="$order"></x-order-status></td>
            @endif
            <td>{{ $order->since }}</td>
            <td><x-table-actions modelName="order" :model="$order"></x-table-actions></td>
        </tr>
    @endforeach
</x-model-index-page>
