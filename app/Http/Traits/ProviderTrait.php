<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\ProviderScopes;
use App\Http\Traits\Api\ProviderApi;
use App\Mail\SendAdminMail;
use App\Models\Provider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

trait ProviderTrait
{
    use BasicTrait, ProviderScopes, ProviderApi;

    protected static function boot(): void
    {
        parent::boot();

        static::forceDeleting(fn($model) => storage_unlink('demands', $model->logo));
    }

    public static function getInSelectForm(): array
    {
        return Crud::getModelsInSelectedForm(model: self::class, callback: function ($q) {
            $q->whereNotNull('address')->whereNotNull('phone');
        });
    }

    public static function getCreatedProviderPassword($demand): string
    {
        $password = Str::password(length: 10, numbers: false);

        Provider::create([
            'demand_id'  => $demand->id,
            'city_id'    => $demand->city_id,
            'name'       => $demand->name,
            'email'      => $demand->email,
            'phone'      => $demand->phone,
            'address'    => $demand->address,
            'identity'   => $demand->identity,
            'store_name' => $demand->store_name,
            'logo'       => $demand->logo,
            'password'   => $password,
        ]);

        return $password;
    }

    public static function sendAcceptEmail($demand, $password): void
    {
        $message = '<h2>تهانينا تم قَبُول الطلب الخاص بكم بالانضمام الي رينتال أعمال بنجاح</h2>';
        $message .= '<hr>';
        $message .= "<div dir='rtl'><h3>بيانات الدخول الخاصة بك هي : </h3>";
        $message .= "<b>رابط الدخول : </b><h3><a href='" . route('provider.login') . "'>" . route('provider.login') . '</a></h3>';
        $message .= '<b>الايميل : </b><h3>' . $demand->email . '</h3>';
        $message .= '<b>كلمة المرور : </b><h3>' . $password . '</h3></div>';

        Mail::to($demand->email)->send(new SendAdminMail($message, 'طلب انضمام رينتال أعمال'));
    }

    public static function sendRejectMail($demand): void
    {
        $message = '<h2>تم رفض طلبكم المقدم للانضمام الي رينتال أعمال برجاء التواصل مع الإدارة لمزيد من المعلومات ...</h2>';

        Mail::to($demand->email)->send(new SendAdminMail($message, 'طلب انضمام رينتال أعمال'));
    }
}
