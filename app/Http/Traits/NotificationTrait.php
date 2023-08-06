<?php

namespace App\Http\Traits;

use App\Enums\OrderStatus;
use App\Http\Scopes\NotificationScopes;
use App\Http\Traits\Api\NotificationApi;
use App\Http\Traits\Other\{EmployeeNotifications, UserNotifications};

trait NotificationTrait
{
    use BasicTrait,
        NotificationApi,
        NotificationScopes,
        EmployeeNotifications,
        UserNotifications;

    public static function sendUserOrderNotification($order, $status): void
    {
        match ($status) {
            OrderStatus::PENDING            => self::sendUserOrderPending($order),
            OrderStatus::ACCEPTED           => self::sendUserOrderReadyToPay($order),
            OrderStatus::REJECTED           => self::sendUserOrderRejected($order),
            OrderStatus::RETURNS            => self::sendUserOrderReturned($order),
            OrderStatus::PROCESSING         => self::sendUserOrderProcessing($order),
            OrderStatus::PROCESSED          => self::sendUserOrderProcessed($order),
            OrderStatus::IN_DELIVERY        => self::sendUserOrderInDelivery($order),
            OrderStatus::PICK_UP            => self::sendUserOrderReadyForPickUp($order),
            OrderStatus::RECEIVED           => self::sendUserOrderReceived($order),
            OrderStatus::NOT_RECEIVED       => self::sendUserOrderNotReceived($order),
            OrderStatus::DELIVERED          => self::sendUserOrderDelivered($order),
            OrderStatus::CANCELED           => self::sendUserOrderCanceled($order),
            OrderStatus::READY_FOR_DELIVERY => self::sendUserOrderReadyForDelivery($order),
            default                         => ''
        };
    }
}
