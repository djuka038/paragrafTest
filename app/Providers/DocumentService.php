<?php

namespace App\Providers;

use App\Models\Document;

class DocumentService
{

    /**
     *
     * CREATE
     *
     */

    public static function addDocument($originalPdfLocation)
    {
        return Document::create([
            'original_pdf_location' => $originalPdfLocation
        ]);
    }

    /**
     *
     * READ
     *
     */

    public static function getDocuments()
    {
        return Document::get();
    }

    public static function getDocumentById($documentId)
    {
        return Document::find($documentId);
    }

    /**
     *
     * UPDATE
     *
     */

    public static function updateDocument($documentId, $modifiedPdfLocation)
    {
        return Document::where('id', $documentId)->update([
            'modified_pdf_location' => $modifiedPdfLocation
        ]);
    }

    /**
     *
     * DELETE
     *
     */

    public static function deleteDocument($id)
    {
        return Document::destroy($id);
    }
}
