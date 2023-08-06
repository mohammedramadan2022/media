<?php

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

function asset_url($url): string
{
    return app()->environment('production') ? url('/public/' . $url) : url($url);
}

function asset_uploaded_url($url): string
{
    return asset_url('storage/uploaded/' . $url);
}

function storage_uploaded($folder, $file_name): string
{
    return storage_path_normalized('app/public/uploaded/'.$folder.'/'.$file_name);
}

function storage_unlink($folder, $file_name): void
{
    $old = storage_uploaded($folder, $file_name);

    if (($file_name != '') && file_exists($old)) {
        unlink($old);
    }
}

function storage_unlink_pdf_file($filename): void
{
    storage_unlink('files/pdf', $filename);
}

function storage_path_normalized($path): string
{
    return storage_path(normalizePath($path));
}

function storage_unlink_many($folder, $files): void
{
    if (! is_array($files)) {
        return;
    }

    foreach ($files as $file_name) {
        storage_unlink($folder, $file_name);
    }
}

function storage_unlink_many_pdf($files): void
{
    if (! is_array($files)) {
        return;
    }

    foreach ($files as $file_name) {
        storage_unlink_pdf_file($file_name);
    }
}

function get_pdf_viewer($file_name): string
{
    // to use this function make sure that the 'front/pdf/web/viewer.html' path exists first !!

    $path = 'storage/uploaded/files/pdf/';

    $url = str_replace(request()->root(), '', asset_url('front/pdf/web/viewer.html'));

    $url .= '?file=%2f'; // %2f => '/'

    $url .= ! app()->isProduction() ? $path : 'public/'.$path;

    $url .= $file_name;

    return $url;
}

function download_pdf($file_name): BinaryFileResponse|RedirectResponse
{
    if (is_null($file_name)) {
        return back()->with('danger', trans('back.file-not-found'));
    }

    return response()->download(storage_uploaded('files/pdf/', $file_name));
}

function modelForceDelete($model, $id, $hasFCM = true, $file = '', $folder = ''): bool
{
    $model_name = str(getModelFromClass($model))->lower();

    $image_folder = $model_name->plural();

    $currentModel = $model::onlyTrashed()->where('id', $id)->first();

    if (method_exists($currentModel,'image') && isset($currentModel->image))
    {
        storage_unlink($image_folder, $currentModel->image->image);

        $currentModel->image()->delete();
    }

    if (method_exists($currentModel,'images') && isset($currentModel->images))
    {
        foreach ($currentModel->images as $image)
        {
            storage_unlink($image_folder, $image->image);

            $image->delete();
        }
    }

    if ($file != '' && $folder != '')
    {
        storage_unlink($folder, $currentModel->$file);
        storage_unlink('thumbnails',$currentModel->$file . '_thumbnails.jpg');
    }

    if ($hasFCM)
    {
        if ($model_name == 'user' || $model_name == 'doctor')
        {
            $currentModel->fcm()->delete();
            $currentModel->token()->delete();
        }
    }

    return $currentModel->forceDelete();
}

function getMediaInInfo($file_path): array
{
    return getId3()->analyze($file_path);
}

function getMigrationFile($model): string
{
    return \App\Facade\Support\Tools\Directory::migration($model);
}

function getModelMigrationFiles($model): array
{
    return \App\Facade\Support\Tools\Directory::migrations($model);
}
