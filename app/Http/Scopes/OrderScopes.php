<?php

namespace App\Http\Scopes;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;

trait OrderScopes
{
    public function scopeSearch(Builder $query, string $term): Builder
    {
        $query->join('users', 'users.id', '=', 'orders.user_id');

        $query->select(['orders.*']);

        $query->where('users.first_name', 'LIKE', "%$term%");
        $query->orWhere('users.last_name', 'LIKE', "%$term%");
        $query->orWhere('orders.order_no', 'LIKE', "%$term%");
        $query->orWhere('orders.total', 'LIKE', "%$term%");
        $query->orWhere('orders.price', 'LIKE', "%$term%");
        $query->orWhere('orders.discount', 'LIKE', "%$term%");
        $query->orWhere('orders.subtotal', 'LIKE', "%$term%");
        $query->orWhere('orders.tax', 'LIKE', "%$term%");
        $query->orWhere('orders.created_at', 'LIKE', "%$term%");
        $query->orWhere('orders.status', 'LIKE', "%$term%");

        return $query;
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PENDING);
    }

    public function scopeOrPending(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::PENDING);
    }

    public function scopeProcessed(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PROCESSED);
    }

    public function scopeOrProcessed(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::PROCESSED);
    }

    public function scopeProcessing(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::PROCESSING);
    }

    public function scopeOrProcessing(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::PROCESSING);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::ACCEPTED);
    }

    public function scopeOrAccepted(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::ACCEPTED);
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::REJECTED);
    }

    public function scopeOrRejected(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::REJECTED);
    }

    public function scopeInDelivery(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::IN_DELIVERY);
    }

    public function scopeOrInDelivery(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::IN_DELIVERY);
    }

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::DELIVERED);
    }

    public function scopeOrDelivered(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::DELIVERED);
    }

    public function scopeDeliveryToWarehouse(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::DELIVERY_TO_WAREHOUSE);
    }

    public function scopeOrDeliveryToWarehouse(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::DELIVERY_TO_WAREHOUSE);
    }

    public function scopeRetrieving(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::RETRIEVING);
    }

    public function scopeOrRetrieving(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::RETRIEVING);
    }

    public function scopeReadyForDelivery(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::READY_FOR_DELIVERY);
    }

    public function scopeOrReadyForDelivery(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::READY_FOR_DELIVERY);
    }

    public function scopeRejectedByProvider(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::REJECTED_BY_PROVIDER);
    }

    public function scopeOrRejectedByProvider(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::REJECTED_BY_PROVIDER);
    }

    public function scopeNotReceived(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::NOT_RECEIVED);
    }

    public function scopeOrNotReceived(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::NOT_RECEIVED);
    }

    public function scopeRejectedFromWarehouse(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::REJECTED_FROM_WAREHOUSE);
    }

    public function scopeOrRejectedFromWarehouse(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::REJECTED_FROM_WAREHOUSE);
    }

    public function scopeReturns(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::RETURNS);
    }

    public function scopeOrReturns(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::RETURNS);
    }

    public function scopeCanceled(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::CANCELED);
    }

    public function scopeOrCanceled(Builder $query): Builder
    {
        return $query->orWhere('status', OrderStatus::CANCELED);
    }
}
