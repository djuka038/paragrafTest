<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\DocumentService;
use App\Providers\StorageService;

class DocumentController extends Controller
{

    public function getDocuments()
    {
        return response()->json(
            DocumentService::getDocuments()
        );
    }

    public function getDocumentById($documentId)
    {
        return response()->json(
            DocumentService::getDocumentById($documentId)
        );
    }

    public function uploadDocument(Request $request)
    {
        $this->validate($request, [
            'document' => 'required|mimes:pdf|max:10000'
        ]);

        return response()->json(
            DocumentService::addDocument(
                StorageService::getFileUrl(
                    StorageService::putFile($request->file('document'))
                )
            )
        );
    }

    public function updateDocument($documentId, Request $request)
    {
        $this->validate($request, [
            'document' => 'required|mimes:pdf|max:10000'
        ]);

        return response()->json(
            DocumentService::updateDocument(
                $documentId,
                StorageService::getFileUrl(
                    StorageService::putFile($request->file('document'))
                )
            )
        );
    }

    public function deleteDocument($documentId)
    {
        $document = DocumentService::getDocumentById($documentId);

        StorageService::deleteFile(
            substr(
                $document->original_pdf_location,
                strrpos($document->original_pdf_location, '/') + 1
            )
        );
        StorageService::deleteFile(
            substr(
                $document->modified_pdf_location,
                strrpos($document->modified_pdf_location, '/') + 1
            )
        );

        return response()->json(
            DocumentService::deleteDocument($documentId)
        );
    }

    public function downloadDocument($fileName)
    {
        return StorageService::downloadDocument($fileName);
    }

    public function update($id)
    {
        return view('update', ['document' => DocumentService::getDocumentById($id)]);
    }
}
