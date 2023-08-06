<?php

namespace App\Facade\Support\Google;

use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP(): bool
    {
        $user = $this->getUser();

        if ($user->loginSecurity == null || $user->loginSecurity->google2fa_enable == 0) {
            return true;
        }

        return ! $this->isEnabled() || $this->isActivated() || $this->noUserIsAuthenticated() || $this->twoFactorAuthStillValid();
    }

    protected function getGoogle2FASecretKey()
    {
        return $this->getUser()->loginSecurity->{$this->config('otp_secret_column')};
    }
}
