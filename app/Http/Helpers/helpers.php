<?php

use App\Enums\Mimes;
use App\Models\Setting;
use App\Facade\Support\Core\Uploaded;
use App\Facade\Support\Tools\{Currency, MobilePhone};
use Illuminate\Support\Facades\{App, Cache, DB, Route, Schema};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function except($arr, $except): array
{
    return arr()->except($arr, $except);
}

function only($array, $keys): array
{
    return arr()->only($array, $keys);
}

function direction(): string
{
    return app()->isLocale('ar') ? 'rtl' : 'ltr';
}

function currentRoute(): ?string
{
    return request()->route()->getName();
}

function floating($right = 'right', $left = 'left'): string
{
    return isLocale('ar') ? $right : $left;
}

function localeUrl($url, $locale = null): string
{
    return LaravelLocalization::getLocalizedURL($locale, $url);
}

function getSetting($setting_name, $is_cached = false)
{
    if($is_cached)
    {
        return Cache::remember($setting_name.'_cached',3600, function() use($setting_name) {
            return optional(Setting::select(['value'])->active()->where('key', $setting_name)->first())->value;
        });
    }

    return optional(Setting::select(['value'])->active()->where('key', $setting_name)->first())->value;
}

function getTransSetting($setting_name, $is_cached = false)
{
    return getSetting($setting_name . '_' . getLocale(), $is_cached);
}

function getPdfSetting($setting_name, $withCache = false): string
{
    return asset_uploaded_url('files/pdf/' . getSetting($setting_name));
}

function getSettingsByType(string $type)
{
    return \App\Models\Setting::select(['key', 'value'])->where('type', $type)->get();
}

function create_rand_numbers($digits = 4): int
{
    return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}

function setActive($url): string
{
    return request()->is(getLocale() . '/' . $url) ? 'active' : '';
}

function active($route): bool
{
    return Route::is($route);
}

function isLocalised($lang): bool
{
    return LaravelLocalization::getLocalizedURL($lang);
}

function get_settings_image($setting_name, $is_cached = false): string|array
{
    $setting = getSetting($setting_name, $is_cached);

    return ($setting) ? asset_uploaded_url('settings/' . $setting) : Uploaded::default();
}

function is_arabic($value): bool|int
{
    return regex()->arabic($value);
}

function is_arabic_rtl($value): string
{
    return is_arabic($value) ? 'rtl' : 'ltr';
}

function models($model = '')
{
    $models = [
        //        'faq'      => iconWithColor('fa fa-info','dark'),
        'area'     => iconWithColor('fa fa-university', 'secondary'),
        'city'     => iconWithColor('fa fa-city', 'pink'),
        //        'banner' => iconWithColor('fa fa-chalkboard','orange'),
        //        'subject'  => iconWithColor('fa fa-info','info'),
        //        'feature' => iconWithColor('fa fa-mobile-alt','soft-purple'),
        //        'paymentMethod'     => iconWithColor('cash','soft-purple'),
        'section'  => iconWithColor('fa fa-grip-horizontal', 'soft-danger'),
        'category' => iconWithColor('fa fa-hdd', 'soft-dark'),
        //        'trip'              => iconWithColor('airplane','secondary'),
        //        'product'           => iconWithColor('fa fa-shopping-cart','purple'),
        'provider' => iconWithColor('fa fa-users-cog', 'soft-secondary'),
        //        'subscription'      => iconWithColor('credit-card','soft-pink'),
    ];

    return $model != '' ? $models[$model] : $models;
}

function getStatisticsCounters(): array
{
    return [
        'role'     => [
            'color'   => 'success',
            'icon'    => 'fa fa-fingerprint',
            'count'   => getModelCount('role'),
            'is_soft' => false,
        ],
        'admin'    => [
            'color'   => 'info',
            'icon'    => 'fa fa-user-secret',
            'count'   => getModelCount('admin'),
            'is_soft' => false,
        ],
        'contact'  => [
            'color'   => 'pink',
            'icon'    => 'fa fa-envelope',
            'count'   => getModelCount('contact'),
            'is_soft' => false,
        ],
        'faq'      => [
            'color'   => 'purple',
            'icon'    => 'fa fa-info',
            'count'   => getModelCount('faq'),
            'is_soft' => false,
        ],
        'banner'   => [
            'color'   => 'primary',
            'icon'    => 'fa fa-chalkboard',
            'count'   => getModelCount('banner'),
            'is_soft' => true,
        ],
        // =================================================================
        'category' => [
            'color'   => 'dark',
            'icon'    => 'fa fa-truck-moving',
            'count'   => getModelCount('category'),
            'is_soft' => true,
        ],
        'city'     => [
            'color'   => 'secondary',
            'icon'    => 'fa fa-city',
            'count'   => getModelCount('city'),
            'is_soft' => true,
        ],
        'section'  => [
            'color'   => 'danger',
            'icon'    => 'fa fa-grip-horizontal',
            'count'   => getModelCount('section'),
            'is_soft' => true,
        ],
        'spec'     => [
            'color'   => 'secondary',
            'icon'    => 'fa fa-check-square',
            'count'   => getModelCount('spec'),
            'is_soft' => false,
        ],
        'preview'  => [
            'color'   => 'success',
            'icon'    => 'fa fa-info',
            'count'   => getModelCount('preview'),
            'is_soft' => false,
        ],
        'feature'  => [
            'color'   => 'info',
            'icon'    => 'fa fa-newspaper',
            'count'   => getModelCount('feature'),
            'is_soft' => false,
        ],
        'product'  => [
            'color'   => 'dark',
            'icon'    => 'fa fa-briefcase',
            'count'   => getModelCount('product'),
            'is_soft' => false,
        ],
        // =================================================================
        'subject'  => [
            'color'   => 'success',
            'icon'    => 'fa fa-info',
            'count'   => getModelCount('subject'),
            'is_soft' => true,
        ],
        'coupon'   => [
            'color'   => 'info',
            'icon'    => 'fa fa-money-bill-wave-alt',
            'count'   => getModelCount('coupon'),
            'is_soft' => true,
        ],
        'provider' => [
            'color'   => 'pink',
            'icon'    => 'fa fa-users-cog',
            'count'   => getModelCount('provider'),
            'is_soft' => true,
        ],
        'order'    => [
            'color'   => 'dark',
            'icon'    => 'fa fa-cart-arrow-down',
            'count'   => getModelCount('order'),
            'is_soft' => true,
        ],
    ];
}

function getModelCount($model, $withDeleted = false): int
{
    /** @var \Illuminate\Database\Eloquent\Model $mo */
    $mo = getClass($model);

    if ($withDeleted)
    {
        if ($model == 'admin') return $mo::onlyTrashed()->where('role_id', '!=', 1)->count();

        return $mo::onlyTrashed()->count() ?? 0;
    }

    if ($model == 'admin') return $mo::where('role_id', '<>', 1)->count();

    if ($model == 'role') return $mo::where('id', '<>', 1)->count();

    if (App::isLocal())
    {
        $key = $model . '_count_cached';

        if (Cache::has($key)) return Cache::get($key);

        Cache::add($key, $mo::count(), now()->addHour());

        return Cache::get($key);
    }

    return $mo::count();
}

function getSettingInCollection($collection, $key): string
{
    return $collection->where('key', $key)->first()->value ?? trans('back.no-value');
}

function getPlainPhone($number, $country_code = '966'): string
{
    return MobilePhone::plain($number, $country_code);
}

function getFormattedPhone($number): string
{
    return MobilePhone::setPrefix($number);
}

function setPhoneToDefault($phone): string
{
    return getFormattedPhone(MobilePhone::convertNumTo($phone));
}

function getFormattedException($e): string
{
    return $e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine();
}

function changeStatusNotIn($model): bool
{
    return in_array($model, [
        'commission', 'payment', 'transaction', 'reservation',
        'notification', 'subscription', 'demand', 'contact',
        'video', 'transfer', 'activity', 'hire', 'vote',
        'order',
    ]);
}

function dataTableNotIn($model): bool
{
    return in_array($model, ['notification']);
}

function setValidationLang($lang)
{
    return $lang == 'ar' ? new \App\Rules\IsAr() : new \App\Rules\IsEn();
}

function script($url, $options = []): string
{
    return Html::script(asset_url($url), $options);
}

function style($url, $options = []): string
{
    return Html::style(asset_url($url), $options);
}

function meta($name, $content, $options = []): string
{
    $others = '';

    if (count($options) > 0) {
        foreach ($options as $key => $option) {
            $others .= $key . '=' . $option . ' ';
        }
    }

    return '<meta name="' . $name . '" content="' . $content . '" ' . $others . '/>';
}

function admin($property = ''): object|string
{
    $admin = (object)auth()->guard('admin')->user();

    return $property ? (string)$admin->$property : $admin;
}

function rootAsset($path = ''): string
{
    return asset_url('/' . $path);
}

function root(): string
{
    return request()->root();
}

function getLocale(): string
{
    return app()->getLocale();
}

function isLocale($locale): bool
{
    return app()->isLocale($locale);
}

function get_input_attributes($type, $name, $slug, $value = null, $col = 12, $dir = 'rtl'): array
{
    return [
        'type'  => $type,
        'name'  => $name,
        'style' => 'form-control form-data',
        'col'   => $col,
        'slug'  => is_arabic($slug) ? $slug : trans('back.' . $slug),
        'value' => $value,
        'dir'   => $dir,
    ];
}

function ds(): string
{
    return DIRECTORY_SEPARATOR;
}

function sitelangs()
{
    return config('sitelangs.locales');
}

function showTabPane($con1, $con2 = '')
{
    return request()->has('page') ? $con1 : $con2;
}

function getFlagLang($flag = ''): string
{
    $lang = app()->isLocale('ar') ? 'sa' : 'gb';

    if ($flag != '') $lang = $flag;

    return asset_url('admin/images/flags/' . $lang . '.png');
}

function setFileType($mime_type): string
{
    return match ($mime_type) {
        Mimes::PDF                                                          => 'pdf',
        Mimes::AUDIO_3GPP, Mimes::VIDEO_3GPP, Mimes::AUDIO_MPEG, Mimes::MP4 => 'audio',
        default                                                             => 'image'
    };
}

function getAudioInSeconds($file_path)
{
    return getMediaInInfo($file_path)['playtime_seconds'];
}

function exceptedPhones(): array
{
    return ['545218563', '1007153688', '545218560', '545218500', '505555555'];
}

function checkIfTableHas($model, $column): bool
{
    return Schema::hasColumn(plural_parts($model)->snake(), $column);
}

function checkIfTableSoftDeleted($model): bool
{
    return checkIfTableHas($model,'deleted_at');
}

function no_status_collections($model): bool
{
    $data = ['notification', 'payment', 'demand', 'vote'];

    return in_array($model, $data);
}

function setProviderWallet($provider, $balanceWithCommission): int
{
    $currentAmount = is_null($provider->wallet) ? 0 : $provider->wallet;

    return (int)$currentAmount + (int)$balanceWithCommission;
}

function localizeDate($date)
{
    return collections()->localizeDate($date);
}

function money($amount): string
{
    return Currency::default($amount);
}

function getTokenable(): string
{
    return request()->bearerToken() ?? '';
}

function getSettingsInputFiles(): array
{
    return ['jpg', 'jpeg', 'png', 'svg'];
}

function is_url($url): bool
{
    return (bool)regex()->url($url);
}

function set_activity($performedOn, $causedBy, $log, $logName = null): void
{
    activity($logName)->performedOn($performedOn)->causedBy($causedBy)->log($log);
}

function set_admin_activity($performedOn, $log, $logName = null): void
{
    activity($logName)->performedOn($performedOn)->causedBy(admin())->log($log);
}

function set_activity_color($name): string
{
    return match ($name) {
        'add'    => 'green',
        'update' => '#5089de',
        default  => 'red',
    };
}

function show_section($setting): string
{
    return getSetting($setting) ? '' : 'display: none;';
}

function seo($other = []): array
{
    return array_merge([
        'author'      => getTransSetting('app_name', true),
        'description' => getTransSetting('contact_description', true),
        'keywords'    => getSetting('contact_tags', true),
        'image'       => get_settings_image('seo_image_logo', true),
        'name'        => getTransSetting('app_name', true),
    ], $other);
}

function set_trans_default_value($name)
{
    $request = request();

    return $request['en'][$name] ?? google_translate()->trans($request['ar'][$name], 'en', 'ar');
}

function map($arr, $callback)
{
    return array_map($callback, $arr);
}

function filter($arr, $callback): array
{
    return array_filter($callback, $arr);
}

function getTables(): array
{
    $query = 'SELECT table_name as `table_name` FROM information_schema.tables WHERE table_schema = :table_schema AND table_name LIKE :table_prefix';

    $tables = DB::select($query, [
        'table_schema' => DB::connection()->getDatabaseName(),
        'table_prefix' => '%' . DB::connection()->getTablePrefix() . '%',
    ]);

    return collect($tables)->pluck('table_name')->toArray();
}

function main_logo_url(): string
{
    return asset_url('admin/images/rental-dark.svg');
}

function main_mail_logo_url(): string
{
    return asset_url('admin/images/rental-dark.png');
}

function has_null($arr): bool
{
    return in_array(null, $arr,true);
}

function getBoolSetting($setting_name): bool
{
    return (bool)getSetting($setting_name);
}

function is_api_path(): bool
{
    return str(request()->url())->contains('api');
}
