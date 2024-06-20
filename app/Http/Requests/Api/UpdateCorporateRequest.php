<?php

namespace App\Http\Requests\Api;

use App\Models\City;
use App\Models\CorporateDocument;
use App\Models\Country;
use App\Models\Document;
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
        $cityConnection    = (new City())->getConnectionName();
        $countryConnection = (new Country())->getConnectionName();

        return [
            'corporate_id' => 'required|exists:corporates,id',
            'name'         => 'required|unique:corporates,name,' . $this->corporate_id,
            'address'      => 'required',
            'logo'         => 'nullable|mimetypes:image/png,image/jpg,image/jpeg',
            'phone'        => 'required|unique:corporates,phone,' . $this->corporate_id,
            'email'        => 'required|unique:corporates,email,' . $this->corporate_id,
            'status'       => 'nullable|in:Active,In Active,Blocked,Black Listed,Under Review,Not Completed',
            'city_id'      => "required|exists:$cityConnection.cities,id",
            'country_id'   => "required|exists:$countryConnection.countries,id",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if the input status is 'Active'
            if ($this->input('status') == 'Active') {
                // Fetch all required documents
                $requiredDocuments = Document::where('is_required', true)->get();

                // Fetch all corporate documents
                $corporateDocuments = CorporateDocument::where('corporate_id', $this->corporate_id)->get();

                // Check for missing or not approved documents
                $missingDocuments = [];
                $notApprovedDocuments = [];

                foreach ($requiredDocuments as $requiredDocument) {
                    $approvedDocument = $corporateDocuments->firstWhere('document_id', $requiredDocument->id);

                    if (!$approvedDocument) {
                        $missingDocuments[] = $requiredDocument->name;
                    } else {
                        // Check if there's any approved document with the same document_id
                        $approved = $corporateDocuments->where('document_id', $requiredDocument->id)
                            ->contains(function ($value, $key) {
                                return $value->status === 'Approved';
                            });

                        if (!$approved) {
                            $notApprovedDocuments[] = [
                                'name' => $requiredDocument->name,
                                'status' => $approvedDocument->status
                            ];
                        }
                    }
                }

                if (!empty($missingDocuments)) {
                    $validator->errors()->add('status', 'Corporate is missing required documents: ' . implode(', ', $missingDocuments));
                }

                if (!empty($notApprovedDocuments)) {
                    $message = 'The following documents are not approved: ';
                    foreach ($notApprovedDocuments as $doc) {
                        $message .= "{$doc['name']} (Status: {$doc['status']}), ";
                    }
                    $message = rtrim($message, ', '); // Remove trailing comma and space
                    $validator->errors()->add('status', $message);
                }
            }
        });
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
