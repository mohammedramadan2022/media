<?php

namespace App\Facade\Traits;

use App\Facade\Support\Tools\Time;
use FFMpeg\{Coordinate, FFMpeg};
use Illuminate\Support\Facades\File;

trait UploadedTrait
{
    public static function setOrUpdateModelImage($model, $file, $folder)
    {
        $image = self::image($file, $folder);

        if ($model->image) return $model->image()->update(['image' => $image]);

        return $model->image()->create(['image' => $image]);
    }

    public static function makeDir($folder): string
    {
        $path = storage_path_normalized('app/public/uploaded/' . $folder . '/');

        File::ensureDirectoryExists($path,0777);

        return $path;
    }

    public static function getFileName($file, $type): string
    {
        $name = $type . '_'; // model file prefix

        $name .= random(12) . '_'; // random string

        $name .= date('Y-m-d') . '.'; // current date

        $name .= strtolower($file->getClientOriginalExtension()); // file extension

        return $name;
    }

    public static function default(): string
    {
        return asset_url('admin/img/photo2.jpg');
    }

    public static function getVideoInfo($video_path): array
    {
        $file = getMediaInInfo($video_path);

        return [
            'duration' => Time::getTimeFromSeconds($file['playtime_seconds']),
            'width'    => $file['video']['resolution_x'],
            'height'   => $file['video']['resolution_y'],
        ];
    }

    // helpers

    private static function defaultThumbnail(): string
    {
        return asset_url('admin/img/thumbnail.jpg');
    }

    private static function storageVideoFilePath($file): string
    {
        return storage_uploaded('files/video', $file);
    }

    private static function getFinalResult($videoName, $thumbnail_image, $getVideoInfo, $file): array
    {
        return [
            'file'           => $videoName,
            'size'           => $file->getSize(),
            'width'          => $getVideoInfo['width'],
            'height'         => $getVideoInfo['height'],
            'duration'       => $getVideoInfo['duration'],
            'thumbnail_name' => $thumbnail_image,
        ];
    }

    private static function setVideoFFMPEG($file, $thumbnail_path, $thumbnail_image, $video_full_path): \FFMpeg\Media\Video|\FFMpeg\Media\Audio
    {
        $ffmpeg = FFMpeg::create();

        $video = $ffmpeg->open($file);

        // reduce the video resolution;
        //        $video->filters()->resize(new Coordinate\Dimension(320, 240))->synchronize();

        $video->frame(Coordinate\TimeCode::fromSeconds(4))->save($thumbnail_path . '/' . $thumbnail_image);

        $video->save(app('\FFMpeg\Format\Video\X264'), $video_full_path);

        return $video;
    }

    private static function setFFmpegThumbnail($file, $thumbnail_path, $thumbnail_image): void
    {
        $ffmpeg = FFMpeg::create();

        $video = $ffmpeg->open($file);

        $video->frame(Coordinate\TimeCode::fromSeconds(4))->save($thumbnail_path . '/' . $thumbnail_image);
    }
}
