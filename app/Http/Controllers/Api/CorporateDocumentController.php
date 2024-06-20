<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CorporateDocumentRequest;
use App\Http\Requests\Api\GetCorporateByIdRequest;
use App\Http\Requests\Api\GetCorporateDocumentByIDRequest;
use App\Http\Requests\Api\UpdateCorporateDocumentStatusRequest;
use App\Http\Resources\CorporateDocumentResource;
use App\Models\Corporate;
use App\Models\CorporateDocument;
use App\Models\Document;
use App\Traits\Responses;
use App\Traits\UploadFilesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CorporateDocumentController extends Controller
{
    use Responses, UploadFilesTrait;

    public function index(GetCorporateByIdRequest $request)
    {
        $data = $request->all();

        $corporate_documents = CorporateDocument::where('corporate_id', $data['corporate_id'])->orderBy('id', 'DESC')->with(['corporate', 'document'])->paginate(10);

        return $this->successPaginated(data: CorporateDocumentResource::collection($corporate_documents), status: Response::HTTP_OK, message: 'All Corporate Documents.');
    }

    public function createCorporateDocument(CorporateDocumentRequest $request)
    {
        $data = $request->all();
        $document = Document::find($data['document_id']);

        if ($document->data_type == 'file' && isset($data['value'])) {
            $file_new_name = $data['value']->hashName();
            $data['value']->move($this->createDirectory("corporates/{$request->input('corporate_id')}/documents"), $file_new_name);
            $data['value'] = "corporates/{$request->input('corporate_id')}/documents/" . $file_new_name;
        }

        $corporateDocument = CorporateDocument::create($data);

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Document created successfully', data: new CorporateDocumentResource($corporateDocument));
    }

    public function updateCorporateDocumentStatus(UpdateCorporateDocumentStatusRequest $request)
    {
        $data = $request->all();

        $corporate_document = CorporateDocument::where('id', $data['corporate_document_id'])->first();

        $corporate_document->update(['status' => $data['status']]);

        $corporate_document->load('document', 'corporate');

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Document Status updated successfully', data: new CorporateDocumentResource($corporate_document));
    }

    public function getCorporateDocumentById(GetCorporateDocumentByIDRequest $request)
    {
        $data = $request->all();
        $corporate_document = CorporateDocument::where('id', $data['corporate_document_id'])->with(['document', 'corporate'])->first();

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Document Details successfully', data: new CorporateDocumentResource($corporate_document));
    }

    public function deleteCorporateDocument(GetCorporateDocumentByIDRequest $request)
    {
        $data = $request->all();
        $corporate_document = CorporateDocument::where('id', $data['corporate_document_id'])->first();
        $document = Document::findOrFail($corporate_document->document_id);

        if ($document->data_type == 'file' && $corporate_document->value) {
            $this->deleteFile($corporate_document->value);
        }

        $corporate_document->delete();

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Document Deleted successfully', data: new CorporateDocumentResource($corporate_document));
    }
}
