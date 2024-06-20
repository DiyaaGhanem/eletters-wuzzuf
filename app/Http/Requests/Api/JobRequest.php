<?php

namespace App\Http\Requests\Api;

use App\Models\City;
use App\Models\Country;
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
        $cityConnection    = (new City())->getConnectionName();
        $countryConnection = (new Country())->getConnectionName();

        return [
            'title'           => 'required|string',
            'department'      => 'required|string',
            'status'          => 'nullable|in:Pending,Published,Rejected,Not Published',
            'job_type'        => 'required|string',
            'job_location'    => 'required|string',
            'job_requirement' => 'required|string',
            'job_level'       => 'required|string',
            'job_questions'   => 'required|array',
            'min_salary'      => 'nullable|numeric',
            'max_salary'      => 'nullable|numeric',
            'category_id'     => 'required|array|min:1|exists:categories,id',
            'skill_id'        => 'required|array|min:1|exists:skills,id',
            'corporate_id'    => 'nullable|exists:corporates,id',
            'city_id'         => "required|exists:$cityConnection.cities,id",
            'country_id'      => "required|exists:$countryConnection.countries,id",
        ];
    }


    public function messages(): array
    {
        return [
            'status.in' => 'The status must be one of the following options: Pending, Published, Rejected, Not Published.',
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
