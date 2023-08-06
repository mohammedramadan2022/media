@props(['order'])

@php use App\Enums\OrderStatus; use App\Enums\PaymentEnum; @endphp

@if(is_null($order->payment_id) && $order->payment_method == PaymentEnum::CASH && $order->status == OrderStatus::DELIVERED)
    <a class="btn btn-outline-success" href="{{ route('orders.order-cash-paid', $order->id) }}">
        @lang('back.confirm')
    </a>
@elseif($order->payment_status == PaymentEnum::PAID)
    <span class="badge @if(Route::is('orders.index')) display-block @endif badge-success f-12 p-2">
        @lang('back.payed')
    </span>
@elseif($order->payment_status == PaymentEnum::NOT_PAID)
    <span class="badge @if(Route::is('orders.index')) display-block @endif badge-danger f-12 p-2">
        @lang('back.not-payed')
    </span>
@elseif($order->payment_status == PaymentEnum::DELAYED)
    <span class="badge @if(Route::is('orders.index')) display-block @endif badge-warning f-12 text-dark p-2">
        @lang('back.delayed')
    </span>
@elseif($order->payment_status == PaymentEnum::WAIT_TO_PAY)
    <span class="badge @if(Route::is('orders.index')) display-block @endif badge-light-info f-12 p-2">
        @lang('back.wait-to-pay')
    </span>
@elseif($order->payment_status == PaymentEnum::OWES_A_DELAY)
    <span class="badge @if(Route::is('orders.index')) display-block @endif badge-light-warning f-12 p-2">
        <i class="fa fa-warning"></i> @lang('back.owes-a-delay')
    </span>
@else
    <span class="badge @if(Route::is('orders.index')) display-block @endif badge-light f-12 text-dark p-2">
        @lang('back.unknown')
    </span>
@endif
