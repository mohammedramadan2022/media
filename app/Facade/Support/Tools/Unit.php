<?php

namespace App\Facade\Support\Tools;

class Unit
{
    public function fileSize($file_size)
    {
        $kilobytes = $file_size / 1024; // convert size from bytes to kilobytes;

        if ($kilobytes < 1024) return self::formatFileSize($kilobytes,'kilobyte');

        if ($kilobytes > 1024)
        {
            $megabytes = ($kilobytes / 1024);

            if ($megabytes > 1024) return self::formatFileSize($megabytes / 1024,'gigabyte');

            return self::formatFileSize($megabytes,'megabyte');
        }

        return $file_size;
    }

    private static function formatFileSize($size, $type): string
    {
        return limit($size,5,'') . ' ' . trans('back.' . $type);
    }
}
