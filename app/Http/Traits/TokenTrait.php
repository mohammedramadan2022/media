<?php

namespace App\Http\Traits;

use App\Models\Token;

trait TokenTrait
{
    public static function createToken($createdModel, $jwt, $type)
    {
        return Token::create(self::setData($createdModel, $type, $jwt));
    }

    private static function setData($createdModel, $type, $jwt): array
    {
        return [
            'tokenable_id'   => $createdModel->id,
            'tokenable_type' => $type,
            'jwt'            => $jwt,
            'ip'             => request()->ip(),
        ];
    }
}
