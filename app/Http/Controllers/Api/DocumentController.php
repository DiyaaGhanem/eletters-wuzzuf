<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DocumentRequest;
use App\Http\Requests\Api\GetDocumentByIdRequest;
use App\Http\Requests\Api\UpdateDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocumentController extends Controller
{
    use Responses;

    public function index()
    {
        $documents = Document::orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: DocumentResource::collection($documents), status: Response::HTTP_OK, message: 'All documents.');
    }

    public function createDocument(DocumentRequest $request)
    {
        $data = $request->all();

        $document = Document::create($data);

        return $this->success(status: Response::HTTP_OK, message: 'Document Created Successfully!!.', data: new DocumentResource($document));
    }

    public function updateDocument(UpdateDocumentRequest $request)
    {
        $data = $request->all();
        $document = Document::where('id', $data['document_id'])->first();
        $document->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Document Updated Successfully!!.', data: new DocumentResource($document));
    }

    public function deleteDocument(GetDocumentByIdRequest $request)
    {
        $data = $request->all();
        $document = Document::find($data['document_id']);

        if (is_null($document)) {
            return $this->error(status: Response::HTTP_OK, message: 'Document Not Found!!.');
        }

        $document->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Document Deleted Successfully!!.', data: new DocumentResource($document));
    }

    public function getDocumentById(GetDocumentByIdRequest $request)
    {
        $data = $request->all();
        $document = Document::where('id', $data['document_id'])->first();

        return $this->success(status: Response::HTTP_OK, message: 'Document Details.', data: new DocumentResource($document));
    }
}
