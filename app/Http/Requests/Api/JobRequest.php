<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;


class JobRequest extends FormRequest
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
            'title'           => 'required|string',
            'department'      => 'required|string',
            'status'          => 'nullable|in:Pending,Published,Rejected,Not Published',
            'job_type'        => 'required|string',
            'country'         => 'required|string',
            'job_location'    => 'required|string',
            'job_requirement' => 'required|string',
            'job_level'       => 'required|string',
            'job_questions'   => 'required|array',
            'min_salary'      => 'required|numeric',
            'max_salary'      => 'required|numeric',
            'category_id'     => 'required|array|min:1|exists:categories,id',
            'skill_id'        => 'required|array|min:1|exists:skills,id',
            'corporate_id'    => 'nullable|exists:corporates,id',
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
