<?php

namespace App\Http\Traits\Other;

use App\Rules\PasswordRule;

trait AuthLoginTrait
{
    public static function passwordResetData($email, $token): array
    {
        return [
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ];
    }

    public static function getValidationRules(): array
    {
        return [
            'token' => ['required', 'string'],
            'new_password' => ['required', 'string', new PasswordRule(), 'confirmed'],
        ];
    }

    private static function getCredentials($request): array
    {
        return [
            self::getUsername() => $request->get(self::getUsername()),
            'password' => $request->password,
        ];
    }

    private static function getRedirectInput($request)
    {
        return $request->only(['email']);
    }

    private static function getUsername(): string
    {
        return is_numeric(request('email')) ? 'phone' : 'email';
    }
}
