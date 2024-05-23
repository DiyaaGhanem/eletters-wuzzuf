<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplicantRequest extends FormRequest
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
        $userConnection = (new User())->getConnectionName();

        return [
            'name'      => 'required',
            'job_title' => 'required',
            'email'     => 'required|email|unique:applicants,email',
            'phone'     => 'required|unique:applicants,phone',
            'country'   => 'required',
            'city'      => 'required',
            'bio'       => 'required',
            'user_id'   => "required|exists:$userConnection.users,id",
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
