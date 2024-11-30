<?php

namespace App\Services;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;

class UploadFileService
{
    public function compressFile($image, $path, $imageName)
    {
        $image_resize = Image::make(public_path($path) . '/' . $imageName);
        $image_resize->fit(250);
        $image_resize->save(public_path($path) . '/' . 'compress/' . $imageName);

        return $imageName;
    }

    public function uploadFile($image, $path, $imagePrefix = null)
    {
        $imageName = $imagePrefix . '-' . uniqid() . '-' . $image->getClientOriginalName();
        $image->move(public_path($path), $imageName);

        return $imageName;
    }

    public function moveTempFileToLocal($base_path, $destination_path)
    {
        File::move(public_path($base_path), public_path($destination_path));
    }

    public function deleteFile($file, $path)
    {
        if (file_exists(public_path() . '/' . $path . '/' . $file)) {
            @unlink(public_path() . '/' . $path . '/' . $file);
            return true;
        } else {
            return false;
        }
    }
}
