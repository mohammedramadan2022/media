<?php

namespace App\Facade\Support\Tools;

use Illuminate\Support\Facades\Route;

class CrudTranslation
{
    public static function trans($table, $controller, $withShow = true, $callback = null): void
    {
        $model = singular($table);

        Route::resource($table, $controller, ['except' => ['show', 'destroy']]);

        Route::post('/' . plural_parts($table) . '/ajax-delete-' . plural_parts($model)->singular(), [$controller, 'delete'])->name(plural_parts($table) . '.ajax-delete-' . plural_parts($model)->singular());

        Route::post('/' . plural_parts($table) . '/ajax-change-' . plural_parts($model) . '-status', [$controller, 'ChangeStatus'])->name(plural_parts($table) . '.ajax-change-' . plural_parts($table) . '-status');

        if ($withShow) {
            Route::get("/$table/{" . $model . '}/show', [$controller, 'show'])->name("$table.show");
        }

        Route::get("/$table/export", [$controller, 'export'])->name("$table.export");

        Route::get("$table/get/trashed", [$controller, 'trashed'])->name("$table.trashed");

        Route::get("/$table/restore/{id}/trashed", [$controller, 'restore'])->name("$table.restore");

        Route::get("/$table/delete/{id}/trashed", [$controller, 'forceDelete'])->name("$table.delete");

        Route::get("/$table/search", [$controller, 'search'])->name("$table.search");

        if ($callback) {
            Route::group([], $callback);
        }
    }

    public static function getCrudTrans($model, $lang = 'en', $gender = 'male', $merge = []): array
    {
        $new_ar = $gender == 'male' ? 'جديد' : 'جديدة';

        $plural = plural($model);

        $ar_plural = trans('back.' . $plural . '.' . $plural);

        $singular = trans('back.' . $plural . '.' . $model);

        $translation = $lang == 'ar' ? self::arabic($plural, $model, $ar_plural, $singular, $new_ar) : self::english($plural, $model);

        if (count($merge) > 0) {
            return array_merge($translation, $merge);
        }

        return $translation;
    }

    private static function arabic($plural, $model, $ar_plural, $singular, $new_ar): array
    {
        return [
            (string)$plural                                   => $ar_plural,
            'index'                                           => 'رئيسية ' . $ar_plural,
            'ajax-delete-' . $model                           => 'حذف ' . $singular . ' موجودة ',
            'ajax-change-' . plural_parts($model) . '-status' => 'تغير حالة التفعيل ل' . $singular,
            'create'                                          => 'صفحة إنشاء ' . $singular . ' ' . $new_ar,
            'store'                                           => 'حفظ ' . $singular . ' ' . $new_ar,
            'edit'                                            => 'صفحة تعديل ' . $singular,
            'update'                                          => 'تحديث بيانات ' . $singular,
            'show'                                            => 'عرض ' . $singular,
            'search'                                          => 'البحث في جدول ' . $ar_plural,
            'export'                                          => 'تصدير ' . $ar_plural . ' كملف إكسيل',
            'trashed'                                         => 'عرض ' . $ar_plural . ' المحذوفين ',
            'restore'                                         => 'إسترجاع ' . $singular . ' محذوف ',
            'delete'                                          => 'حذف ' . $singular . ' نهائيا ',
        ];
    }

    private static function english($plural, $model): array
    {
        return [
            (string)$plural->lower()                          => $plural->ucfirst(),
            'ajax-delete-' . $model                           => 'Delete exist ' . $model,
            'ajax-change-' . plural_parts($model) . '-status' => 'Change ' . $model . ' status',
            'index'                                           => $plural->ucfirst() . ' Page',
            'create'                                          => 'Create new ' . $model . ' page',
            'store'                                           => 'Save new ' . $model,
            'edit'                                            => 'Edit ' . $model,
            'update'                                          => 'Update ' . $model,
            'show'                                            => 'Show ' . $model,
            'export'                                          => 'Export ' . $plural . ' table to excel file',
            'trashed'                                         => 'Show trashed ' . $plural,
            'restore'                                         => 'Restore a ' . $model,
            'delete'                                          => 'Remove ' . $model . ' from trash',
            'search'                                          => 'Search in ' . $plural,
        ];
    }
}
