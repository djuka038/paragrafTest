<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;

class StorageService
{

    const DOCUMENTS_FOLDER = 'public/PdfDocuments';

    /**
     *
     * CREATE
     *
     */

    /**
     * Saves file to the folder
     *
     * @param File $file
     * @return string file path
     */
    public static function putFile($file)
    {
        return Storage::putFile(self::DOCUMENTS_FOLDER, $file);
    }

    /**
     *
     * READ
     *
     */

    /**
     * Gets file url
     *
     * @param string $path
     * @return string
     */
    public static function getFileUrl($path)
    {
        return Storage::url($path);
    }

    public static function downloadDocument($fileName)
    {
        return Storage::download(self::DOCUMENTS_FOLDER . '/' . $fileName);
    }

    /**
     *
     * DELETE
     *
     */

    public static function deleteFile($path)
    {
        return Storage::delete(self::DOCUMENTS_FOLDER . '/' . $path);
    }
}
