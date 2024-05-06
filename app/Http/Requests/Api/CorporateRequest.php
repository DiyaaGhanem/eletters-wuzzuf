<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CorporateRequest extends FormRequest
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
            'name'              => 'required|unique:corporates,name',
            'tax_register'      => 'required|unique:corporates,tax_register',
            'commercial_record' => 'required|unique:corporates,commercial_record',
            'country'           => 'required',
            'city'              => 'required',
            'address'           => 'required',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'phone'             => 'required|unique:corporates,phone',
            'email'             => 'required|unique:corporates,email',
            'status'            => 'required|in:Active,In Active,Blocked,Black Listed,Under Review,Not Completed',
            'user_id'           => 'required',
            'logo'              => 'required|mimetypes:image/png,image/jpg,image/jpeg'
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
