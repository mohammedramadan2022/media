<?php

namespace App\Enums;

enum OrderStatus: string
{
    public const ALL = 'all'; // قيد المراجعه

    public const PENDING = 'pending'; // قيد المراجعه

    public const REJECTED = 'rejected'; // مرفوض

    public const ACCEPTED = 'accepted'; // تم القبول

    public const RETURNS = 'returns'; // مرتجع

    public const PROCESSING = 'processing'; // جاري التجهيز

    public const PROCESSED = 'processed'; // تم التجهيز

    public const IN_DELIVERY = 'in_delivery'; // جاري التوصيل

    public const READY_FOR_DELIVERY = 'ready_for_delivery'; // جاهز للتوصيل

    public const PICK_UP = 'ready_for_pick_up'; // جاهز للإستلام

    public const RECEIVED = 'received'; // تم استلام المنتج من العميل

    public const NOT_RECEIVED = 'not_received'; // قام العميل بعمل الطلب ولم يتم استلامه

    public const DELIVERED = 'delivered'; // تم تسليم المنتج للعميل

    public const CANCELED = 'canceled'; // ملغي

    public const RETRIEVING = 'retrieving'; // جاري استعادة المنتج من العميل

    public const RETRIEVED = 'retrieved'; // تم استعادة المنتج من العميل

    public const DELIVERY_TO_WAREHOUSE = 'delivery_to_warehouse'; // جاري التسليم لمسؤول المستودع

    public const REVIEWED = 'reviewed'; // تم مراجعة المنتج واستلامه

    public const REJECTED_FROM_WAREHOUSE = 'rejected_from_warehouse'; // مرفوض من مسؤول المستودع

    public const REJECTED_BY_PROVIDER = 'rejected_by_provider'; // مرفوض من مندوب التوصيل

    public const DELIVERED_TO_MERCHANT = 'delivered_to_merchant'; // تم تسليم المنتج للتاجر
}
