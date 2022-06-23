<?php

namespace App\Services;

use InterventionImage;

class ImageService
{
    public static function upload($image_file, $file_path)
    {
        if (!$image_file == null) {
            $extension = $image_file->extension();
            $file_name = uniqid(rand());
            $file_name_store = $file_name . '.' . $extension;
            InterventionImage::make($image_file)->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($file_path . $file_name_store));
        } else {
            $file_name_store = null;
        }

        return $file_name_store;
    }
}