<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplicationRequest extends FormRequest
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
            'cover_letters'          => 'required|string',
            'notice_period'          => 'required|string',
            'application_date'       => 'required|date',
            'expected_salary'        => 'required|numeric',
            'answers'                => 'required',
            'cv'                     => 'required|mimes:pdf',
            'candidate_profile_link' => 'required|url',
            'job_id'                 => 'required|exists:jobs,id',
            'user_id'           => "required|exists:$userConnection.users,id",
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
