<?php

namespace App\Http\Requests\Api;

use App\Models\CorporateDocument;
use App\Models\Document;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CorporateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function prepareForValidation()
    {
        $corporateId = $this->corporate_id;
        $documentId = $this->document_id;

        // Check if the corporate already has the document with status 'Approved'
        $existingDocument = CorporateDocument::where('corporate_id', $corporateId)
            ->where('document_id', $documentId)
            ->where('status', 'Approved')
            ->first();

        if ($existingDocument) {
            $this->merge(['approved_error' => true]);
        }

        // Check if the corporate already has the document with status 'Under Review'
        $underReviewDocument = CorporateDocument::where('corporate_id', $corporateId)
            ->where('document_id', $documentId)
            ->where('status', 'Under Review')
            ->first();

        if ($underReviewDocument) {
            $this->merge(['under_review_error' => true]);
        }
    }


    public function rules(): array
    {
        // If any document error flags are set, skip further validation
        if ($this->approved_error || $this->under_review_error) {
            return [];
        }

        $rules = [
            'corporate_id' => 'required|exists:corporates,id',
            'document_id' => 'required|exists:documents,id',
            'value' => 'required',
            'status' => 'nullable|in:Under Review,Approved,Rejected',
        ];

        $document = Document::find($this->document_id);
        if ($document) {
            $valueRules = ['required']; // Make sure valueRules is an array

            if ($document->is_unique) {
                $valueRules[] = Rule::unique('corporate_documents', 'value')->where(function ($query) {
                    $document = Document::find($this->document_id);
                    return $document && $document->is_unique == 1
                        ? $query->where('document_id', $this->document_id)
                        ->whereIn('status', ['Under Review', 'Approved'])
                        : $query->whereNull('id'); // No validation if is_unique is not 1
                });
            }

            switch ($document->data_type) {
                case 'email':
                    $valueRules[] = 'email';
                    break;
                case 'number':
                    $valueRules[] = 'numeric';
                    break;
                case 'string':
                    $valueRules[] = 'string';
                    break;
                case 'file':
                    $valueRules[] = 'file';
                    $valueRules[] = 'mimes:pdf,png,jpg,jpeg';
                    break;
            }

            $rules['value'] = $valueRules;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'corporate_id.required' => 'The corporate ID is required.',
            'corporate_id.exists' => 'The selected corporate ID does not exist.',
            'document_id.required' => 'The document ID is required.',
            'document_id.exists' => 'The selected document ID does not exist.',
            'value.required' => 'The document value is required.',
            'value.email' => 'The document value must be a valid email address.',
            'value.numeric' => 'The document value must be a number.',
            'value.string' => 'The document value must be a string.',
            'value.file' => 'The document value must be a file.',
            'value.mimes' => 'The document value must be a file of type: pdf, png, jpg, jpeg.',
            'value.unique' => 'The document value must be unique for this corporate.',
            'status.in' => 'The document status must be one of the following: Under Review, Approved, Rejected.',
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->approved_error) {
                $validator->errors()->add('document_id', 'Document already approved for this corporate.');
            }

            if ($this->under_review_error) {
                $validator->errors()->add('document_id', 'Document is currently under review for this corporate.');
            }

        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
