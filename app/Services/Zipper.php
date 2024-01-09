<?php

namespace App\Services;

use ZipArchive;

class Zipper
{
    public static function createZipFile($jsonFileName)
    {

        $zip = new ZipArchive();
        $zip_file_name = storage_path('app/public/'.'tasks.zip');

        $zip->open($zip_file_name, ZipArchive::CREATE);
        $zip_file_path = storage_path('app/public/'.$jsonFileName);
        $zip->addFile($zip_file_path, $zip_file_name);
        $zip->close();

        return $zip_file_name;
    }
}
