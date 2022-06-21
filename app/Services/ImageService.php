<?php

namespace App\Services;

use InterventionImage;

class ImageService
{
    public static function upload($image_file, $file_path)
    {
        //ファイル名を一意の名前に変更し取得
        $extension = $image_file->extension();
        $file_name = uniqid(rand());
        $file_name_store = $file_name . '.' . $extension;

        //縦のサイズだけリサイズし、storage/app/public/に保存。
        //publicフォルダにシンボリック作成済み
        InterventionImage::make($image_file)->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($file_path . $file_name_store));;

        return $file_name_store;
    }
}