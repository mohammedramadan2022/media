<?php

namespace App\Http\Traits;

use App\Enums\SettingEnum;
use App\Facade\Support\Core\Uploaded;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\Setting;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait SettingTrait
{
    use BasicTrait;

    public static function types(): array
    {
        return ['Text', 'Textarea', 'File', 'Map', 'CKeditor', 'Switch', 'Button'];
    }

    public static function updateAll($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $settings = Setting::all();

            foreach (self::setStatusColumns($settings, $request) as $key => $value) {
                if (! $setting = $settings->where('key', $key)->first()) {
                    continue;
                }

                if (Str::contains($key, ['logo', 'image', 'file']) && is_null($value)) {
                    continue;
                }

                if (is_file($value) && $setting->input == SettingEnum::FILE) {
                    self::handlePdfInputNewFile($setting, $value);
                } elseif ($setting->input == SettingEnum::SWITCH && Str::contains($setting->key, 'status')) {
                    $setting->update(['value' => $request->has($setting->key) ? 1 : 0]);
                } else {
                    $setting->update(['value' => $value]);
                }
            }

            DB::commit();

            return CrudMessage::edit('setting');
        } catch (Exception $e) {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function setRow($key, $name, $type, $input, $value = null): array
    {
        return [
            'key' => $key, 'name' => $name,
            'type' => $type, 'input' => $input, 'value' => $value,
            'created_at' => now(), 'updated_at' => now(),
        ];
    }

    public static function setAppFileRow($key, $name): array
    {
        return self::setRow($key, $name, 'APP', SettingEnum::FILE);
    }

    public static function setSeoTextRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'SEO', SettingEnum::TEXT, $value);
    }

    public static function setApiTextRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'API', SettingEnum::TEXT, $value);
    }

    public static function setApiTextareaRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'API', SettingEnum::TEXTAREA, $value);
    }

    public static function setAboutCKeditorRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'ABOUT', SettingEnum::CKEDITOR, $value);
    }

    public static function setAboutFileRow($key, $name): array
    {
        return self::setRow($key, $name, 'ABOUT', SettingEnum::FILE);
    }

    public static function setSeoFileRow($key, $name): array
    {
        return self::setRow($key, $name, 'SEO', SettingEnum::FILE);
    }

    public static function setContactRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'CONTACTS', SettingEnum::TEXT, $value);
    }

    public static function setContactLocationRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'CONTACTS', SettingEnum::MAP, $value);
    }

    public static function setContactTextareaRow($key, $name, $value): array
    {
        return self::setRow($key, $name, 'CONTACTS', SettingEnum::TEXTAREA, $value);
    }

    private static function handlePdfInputNewFile($setting, $value): void
    {
        $up = $setting->value;

        if (Str::contains($value->getClientMimeType(), 'pdf')) {
            $up = Uploaded::file($value, $setting->value);
        }

        if (Str::contains($value->getClientMimeType(), 'image')) {
            $up = Uploaded::image($value, 'setting', $setting->value);
        }

        if ($up) {
            $setting->update(['value' => $up]);
        }
    }

    private static function setStatusColumns($settings, $req): array
    {
        $arr = [];

        $settingsArr = $req->except(['_token', '_method', 'submit']);

        $_arr = $settings->where('input', SettingEnum::SWITCH)->pluck('key')->toArray();

        foreach ($_arr as $key) {
            $arr[$key] = $req->has($key) ? 1 : 0;
        }

        return array_merge($settingsArr, $arr);
    }
}
