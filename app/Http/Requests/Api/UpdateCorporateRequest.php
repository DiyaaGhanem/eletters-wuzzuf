<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCorporateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'corporate_id'               => 'required|exists:corporates,id',
            'name'                       => 'required|unique:corporates,name,' . $this->corporate_id,
            'tax_register'               => 'required|unique:corporates,tax_register,' . $this->corporate_id,
            'commercial_record'          => 'required|unique:corporates,commercial_record,' . $this->corporate_id,
            'country'                    => 'required',
            'city'                       => 'required',
            'address'                    => 'required',
            'logo'                       => 'nullable|mimetypes:image/png,image/jpg,image/jpeg',
            'tax_register_document'      => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf',
            'commercial_record_document' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf',
            'id_face'                    => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'id_back'                    => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'phone'                      => 'required|unique:corporates,phone,' . $this->corporate_id,
            'email'                      => 'required|unique:corporates,email,' . $this->corporate_id,
            'owner_title'                => 'required|string',
            'status'                     => 'required|in:Active,In Active,Blocked,Black Listed,Under Review,Not Completed',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
