<?php

namespace App\Http\Traits;

use App\Models\Fcm;

trait FcmTrait
{
    use BasicTrait;

    public static function createFcm($createdModel, $type)
    {
        return Fcm::create(self::setData($createdModel, $type));
    }

    public static function updateFcm($model)
    {
        return $model->fcm()->update(['fcm' => request()->device_token ?? null]);
    }

    private static function setData($createdModel, $type): array
    {
        return [
            'fcmable_id'   => $createdModel->id,
            'fcmable_type' => $type,
            'type'         => request()->hasHeader('website') ? 'web' : 'mobile',
            'fcm'          => request()->device_token ?? null,
        ];
    }
}
