@props(['order'])

@php use App\Enums\OrderStatus; @endphp

@if($order->status == OrderStatus::PENDING && is_null($order->is_rental_accept))

    <a href="{{ route('orders.accept', $order->id) }}" style="border-radius: 10%" class="btn btn-outline-success">
        @lang('back.accept')
    </a>
    <a href="{{ route('orders.reject', $order->id) }}" style="border-radius: 10%" class="btn btn-outline-danger">
        @lang('back.refuse')
    </a>

@elseif($order->status == OrderStatus::PENDING && $order->store_products_count > 0 && $order->is_all_accept)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif text-dark badge-warning">
        @lang('back.provider-pending')
    </span>

@elseif($order->status == OrderStatus::REJECTED)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-danger">
        @lang('back.refused')
    </span>

@elseif($order->status == OrderStatus::CANCELED)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-secondary">
        @lang('back.canceled')
    </span>

@elseif($order->status == OrderStatus::PENDING)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif text-dark badge-warning">
        @lang('back.pending')
    </span>

@elseif($order->status == OrderStatus::PROCESSING)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-purple">
        @lang('back.processing')
    </span>

@elseif($order->status == OrderStatus::PROCESSED)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif" style="background-color: #3B0D5F;">
        @lang('back.processed')
    </span>

@elseif($order->status == OrderStatus::READY_FOR_DELIVERY)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-pink">
        @lang('back.ready_for_delivery')
    </span>

@elseif($order->status == OrderStatus::PICK_UP)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-dark">
        @lang('back.ready_for_pick_up')
    </span>

@elseif($order->status == OrderStatus::IN_DELIVERY)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-info">
        @lang('back.in_delivery')
    </span>

@elseif($order->status == OrderStatus::RECEIVED)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-primary">
        @lang('back.received')
    </span>

@elseif($order->status == OrderStatus::DELIVERED)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-light-success">
        @lang('back.delivered')
    </span>

@elseif($order->status == OrderStatus::RETRIEVING)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-light-success">
        @lang('back.retrieving')
    </span>

@elseif($order->status == OrderStatus::REJECTED_BY_PROVIDER)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-light-danger">
        @lang('back.rejected_by_provider')
    </span>

@elseif($order->status == OrderStatus::RETURNS)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-light-warning text-dark">
        @lang('back.returns')
    </span>

@elseif($order->status == OrderStatus::NOT_RECEIVED)

    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-light-danger text-dark">
        @lang('back.notReceived')
    </span>
@elseif(is_null($order->status))
    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-light-danger">
        @lang('back.unknown')
    </span>
@else
    <span class="badge p-2 f-12 @if(Route::is('orders.index')) display-block @endif badge-success">
        @lang('back.'.$order->status)
    </span>
@endif
