<?php

use Illuminate\Support\{Str, Stringable};

function singular($plural): Stringable
{
    return str($plural)->singular();
}

function random($length): string
{
    return Str::random($length);
}

function lower($text): Stringable
{
    return str($text)->lower();
}

function slug($text): Stringable
{
    return str($text)->slug();
}

function limit($string, $limit, $end = '...'): Stringable
{
    return str($string)->limit($limit, $end);
}

function str_limit_30($text): string
{
    return str($text)->limit(30);
}

function uuid(): string
{
    return (string)Str::uuid();
}

function plural($singular): Stringable
{
    return str($singular)->plural();
}

function plural_parts($singular)
{
    if (str($singular)->contains('_')) {
        return str($singular)->camel()->plural();
    }

    return plural($singular);
}

function camel($string): Stringable
{
    return str($string)->camel();
}

function snake($string): Stringable
{
    return str($string)->snake();
}

function contains($string, $term): bool
{
    return str($string)->contains($term);
}

function hashtag($tag): string
{
    return '#' . str_replace(' ', '_', $tag);
}

function tableName($polymorphicClass): string
{
    $name = explode('\\', $polymorphicClass)[2];

    return plural($name)->headline();
}

function getModelName($class): Stringable
{
    return str(last(explode('\\', $class)))->camel();
}

function getClass($model): string
{
    return 'App\Models\\' . plural_parts($model)->singular()->ucfirst();
}

function getModelFromClass($class): string
{
    return lcfirst(last(explode('\\', $class)));
}

function getClassFromModel($model): string
{
    return '\App\Models\\' . ucwords($model);
}

function getYearMonths($month = null): array|string
{
    $months = ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيه', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];

    return $month != null ? $months[$month] : $months;
}

function getMonthsArray($month = null): array|string
{
    $months = [
        'jan' => 'january',
        'feb' => 'february',
        'mar' => 'march',
        'apr' => 'april',
        'may' => 'may',
        'jun' => 'june',
        'jul' => 'july',
        'aug' => 'august',
        'sep' => 'september',
        'oct' => 'october',
        'dec' => 'december',
    ];

    return $month != null ? $months[$month] : $months;
}

function getDaysArray($day = null): array|string
{
    $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

    return $day != null ? $days[$day] : $days;
}

function getWeekDays($day = null): array|string
{
    $days = ['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];

    return $day != null ? $days[$day] : $days;
}

function normalizePath($path): array|string
{
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
}

function googleTranslate($text): ?string
{
    return google_translate()->trans($text, getLocale(), 'ar');
}

function split_string($text, $item): array
{
    $str1 = substr($text,0, floor(strlen($text) / 2));

    $str2 = substr($text, floor(strlen($text) / 2));

    $condition = substr($str1,0,-1) != ' ' and !str_starts_with($str2, ' ');

    $middle = $condition
        ? (strlen($str1) + strpos($str2, ' ') + 1)
        : (strrpos(substr($text, 0, floor(strlen($text) / 2)), ' ') + 1);

    return [substr($text,0, $middle), $item, substr($text, $middle)];
}

function iconWithColor($icon, $color): array
{
    return ['icon' => $icon, 'color' => $color];
}

function formCreateArray($table): array
{
    return [
        'route'  => $table . '.store',
        'method' => 'POST',
        'id'     => $table . 'Form',
        'class'  => 'form-horizontal push-10-t ' . $table . ' ajax create',
        'files'  => true,
    ];
}

function formUpdateArray($model, $table): array
{
    return [
        'url'    => route($table . '.update', $model->id),
        'method' => 'PUT',
        'id'     => $table . 'Form',
        'class'  => 'form-horizontal push-10-t ' . $table . ' ajax edit',
        'files'  => true,
    ];
}

function morrisDonutChart(): array
{
    return ['admin', 'service', 'client'];
}

function checkUrlHas($term): bool
{
    return str($term)->contains(request()->url());
}

function translated($type, $obj): string
{
    return trans('back.' . $type . '-done', [
        'var' => trans('back.' . $obj . '.t-' . $obj->singular()),
    ]);
}

function translatedField($name, $type, $trans): array
{
    return ['name' => $name, 'type' => $type, 'trans' => 'back.' . $trans];
}

function highlightText($text): string
{
    if (!request()->filled('term')) {
        return !is_null($text) ? str_limit_30($text) : trans('back.no-value');
    }

    $mark = '<mark>' . request('term') . '</mark>';

    $pattern = '/(' . request('term') . ')/i';

    return preg_replace($pattern, $mark, $text);
}

function colors(): string
{
    $colors = ['primary', 'pink', 'info', 'danger', 'secondary'];

    shuffle($colors);

    return head($colors);
}

function getMultiSelectForm($name): array
{
    return [
        'class'       => 'form-control select2 form-data',
        'multiple'    => 'multiple',
        'data-style'  => 'btn-light',
        'data-toggle' => 'select2',
        'dir'         => direction(),
        'id'          => head(explode('[]', $name)),
    ];
}

function is_pdf($file): bool
{
    return str($file->getClientMimeType())->contains('pdf');
}

function check_current_route_contains($name): bool
{
    return str(request()->route()->getName())->contains($name);
}

function get_current_icon_file($offset, $length = 0, $with_null = null): array
{
    $icons = ($with_null == null) ? [] : ['' => ''];

    $lines = get_file_in_array(public_path_normalized(config('icons.path')));

    $icons += map(array_slice($lines, $offset, $length), function ($line) {
        $class = str_replace(['::before', ':before', '.'], '', $line);

        return (object)['class' => $class, 'name' => last(explode(config('icons.class') . '-', $class))];
    });

    return $icons;
}

function get_file_in_array($file_path): array
{
    $lines = [];

    $file_content = str_replace(["\r", "\n", "\t", ' '],'', file_get_contents($file_path));

    if ($first = explode('}', $file_content))
    {
        foreach ($first as $value)
        {
            $second = explode('{', $value);

            if (isset($second[0]) && $second[0] !== '')
            {
                $lines[] = trim($second[0]);
            }
        }
    }

    return $lines;
}
