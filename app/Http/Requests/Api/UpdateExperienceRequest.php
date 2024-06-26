<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateExperienceRequest extends FormRequest
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
            'experience_id' => 'required|exists:experiences,id',
            'company'      => 'required',
            'logo'         => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'job_title'      => 'required',
            'description'   => 'required',
            'job_type'      => 'required|in:Full Time,Part Time,Freelance',
            'job_location'  => 'required|in:On Site,Remote,Hybrid',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date',
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
