<?php

namespace App\Http\Requests\Api;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
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
        $userConnection    = (new User())->getConnectionName();
        $cityConnection    = (new City())->getConnectionName();
        $countryConnection = (new Country())->getConnectionName();

        return [
            'name'       => 'required|unique:corporates,name',
            'address'    => 'required',
            'logo'       => 'required|image|mimes:jpeg,jpg,png,gif',
            'phone'      => 'required|unique:corporates,phone',
            'email'      => 'required|email|unique:corporates,email',
            'status'     => 'required|in:Active,In Active,Blocked,Black Listed,Under Review,Not Completed',
            'user_id'    => "required|exists:$userConnection.users,id",
            'city_id'    => "required|exists:$cityConnection.cities,id",
            'country_id' => "required|exists:$countryConnection.countries,id",
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'The status must be one of the following options: Active, In Active, Blocked, Black Listed, Under Review, Not Completed.',
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
