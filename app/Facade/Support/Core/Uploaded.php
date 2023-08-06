<?php

namespace App\Facade\Support\Core;

use App\Facade\Support\Tools\CrudMessage;
use App\Facade\Traits\UploadedTrait;
use App\Models\Image;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{DB, File};
use Intervention\Image\Facades\Image as ImageIntervention;

class Uploaded
{
    use UploadedTrait;

    public static function image($img, $model, $old = null): string
    {
        $filename = self::getFileName($img, lower($model));

        $folder = plural($model)->lower();

        $ex = $img->getClientOriginalExtension();

        if ($old) storage_unlink($folder, $old);

        if ($ex == 'svg')
        {
            $img->storeAs('uploaded'.ds().$folder, $filename, 'public');

            return $filename;
        }

        ImageIntervention::make($img)->save(self::makeDir($folder).$filename);

        return $filename;
    }

    public static function images($files, $model): array
    {
        $images = [];

        foreach ($files as $key => $file) {
            $images[$key]['image'] = self::image($file, $model);
        }

        return $images;
    }

    public static function file($file, $old = null, $type = 'pdf', $folder = 'files'): ?string
    {
        if (! is_file($file)) return null;

        $filename = self::getFileName($file, $type);

        self::makeDir($folder);

        if ($old) storage_unlink($folder.'/'.$type, $old);

        $file->storeAs('uploaded' . ds() . $folder . ds() . $type, $filename, 'public');

        return $filename;
    }

    public static function defaultImage($image, $folder): string
    {
        $imageName = is_string($image)
            ? $image
            : (
                is_object($image) && isset($image->first()->image)
                    ? $image->first()->image
                    : null
            );

        return ! is_null($imageName) ? asset_uploaded_url($folder.'/'.$imageName) : self::default();
    }

    public static function defaultVideo($file): string
    {
        $path = self::storageVideoFilePath($file);

        return (! is_null($file) && File::exists($path)) ? asset_uploaded_url('files/video/'.$file) : '';
    }

    public static function defaultImages($images, $folder): string
    {
        $path = isset($images) && $images->count() > 0 ? storage_uploaded($folder, $images->first()->image) : '';

        $count = count($images->toArray());

        if (is_object($images) && $count > 0 && File::exists($path)) {
            return self::defaultImage($images->first()->image, $folder);
        }

        return self::default();
    }

    public static function removeImage($id, $model): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $image = Image::find($id);

            storage_unlink(plural($model)->lower(), $image->image);

            $image->delete();

            DB::commit();

            return CrudMessage::crudResponse('Done');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public static function updateAndDelete($currentModel, $file_name, $folder)
    {
        $_image = isset($currentModel->image) ? $currentModel->image->image : '';

        $old = $file_name == 'image' ? $_image : $currentModel->$file_name;

        $uploaded = request($file_name);

        // return old if there is no uploaded image file;
        if (! isset($uploaded)) return $old;

        // delete the old image;
        if ($old != '') storage_unlink($folder, $old);

        // update the table row or create it for relationship image();
        return self::setOrUpdateModelImage($currentModel, $uploaded, singular($folder));
    }

    public static function uploadAndCreate($created, $fileName, $model_name)
    {
        if (is_null(request($fileName))) return false;

        if (method_exists($created, 'image')) {
            return $created->image()->create(['image' => self::image(request($fileName), $model_name)]);
        }

        return $created->update([(string) $fileName => self::image(request($fileName), $model_name)]);
    }

    public static function setOrUpdateModelImages($model, $imgs, $model_name)
    {
        if (! isset($imgs) && count($imgs) == 0) return false;

        return $model->images()->createMany(self::images($imgs, $model_name));
    }

    public static function video($file): bool|array
    {
        $videoName = self::file($file,'video');

        $video_full_path = self::storageVideoFilePath($videoName);

        $thumbnail_path = self::makeDir('thumbnails');

        $thumbnail_image = $videoName.'_thumbnails'.'.jpg';

        // this way takes too much time; do not use job queue with this way
        self::setVideoFFMPEG($file, $thumbnail_path, $thumbnail_image, $video_full_path);

        $data = self::getFinalResult($videoName, $thumbnail_image, self::getVideoInfo($video_full_path), $file);

        return $videoName ? $data : false;
    }

    public static function upload($currentModel, $file_name, $model_name)
    {
        $_image = isset($currentModel->image) ? $currentModel->image->image : '';

        if ($_image != '') return self::updateAndDelete($currentModel, $file_name, plural($model_name));

        return self::uploadAndCreate($currentModel, $file_name, $model_name);
    }

    public static function multi($currentModel, $files, $model, $method = 'images')
    {
        return $currentModel->$method()->createMany(self::images($files, $model));
    }

    public static function thumbnail($filename): string
    {
        $path = storage_uploaded('thumbnails', $filename);

        $url = asset_uploaded_url('thumbnails/'.$filename);

        return (! is_null($filename) && File::exists($path)) ? $url : self::defaultThumbnail();
    }

    public static function photos($currentModel, $columns, $model): void
    {
        $row = [];

        foreach ($columns as $column => $image) {
            $row[$column] = request($column) ? self::image(request($column), $model) : $currentModel->$column;
        }

        $currentModel->update($row);
    }

    public static function checkForVideo($request, $fileName): bool|array
    {
        return $request->hasFile($fileName) ? self::video($request->into_video) : [];
    }
}
