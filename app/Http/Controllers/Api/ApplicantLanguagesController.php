<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApplicantLanguageRequest;
use App\Http\Requests\Api\GetApplicantByIdRequest;
use App\Http\Requests\Api\GetApplicantLanguageByIdRequest;
use App\Http\Requests\Api\UpdateApplicantLanguageRequest;
use App\Http\Resources\ApplicantLanguagesResource;
use App\Http\Resources\ApplicantResource;
use App\Models\Applicant;
use App\Models\ApplicantLanguage;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantLanguagesController extends Controller
{
    use Responses;

    public function index()
    {
        $applicantLanguages = ApplicantLanguage::with(['applicant', 'applicant.user', 'language'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: ApplicantLanguagesResource::collection($applicantLanguages), status: Response::HTTP_OK, message: 'All Applicant Languages.');
    }

    public function getApplicantLanguagesByApplicant(GetApplicantByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->with('user', 'languages.language')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applicant Languages Details.', data: new ApplicantResource($applicant));
    }

    public function createApplicantLanguage(ApplicantLanguageRequest $request)
    {
        $data = $request->all();

        $applicantLanguage = ApplicantLanguage::create($data);
        $applicantLanguage->load('applicant', 'applicant.user', 'language');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Language Created Successfully!!.', data: new ApplicantLanguagesResource($applicantLanguage));
    }

    public function updateApplicantLanguage(UpdateApplicantLanguageRequest $request)
    {
        $data = $request->all();
        $applicantLanguage = ApplicantLanguage::findOrFail($data['applicant_language_id']);

        $applicantLanguage->update($data);
        $applicantLanguage->load('applicant', 'applicant.user', 'language');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Language Updated Successfully!!.', data: new ApplicantLanguagesResource($applicantLanguage));
    }

    public function deleteApplicantLanguage(GetApplicantLanguageByIdRequest $request)
    {

        $data = $request->all();
        $applicantLanguage = ApplicantLanguage::find($data['applicant_language_id']);

        $applicantLanguage->load('applicant', 'applicant.user', 'language');

        if (is_null($applicantLanguage)) {
            return $this->error(status: Response::HTTP_OK, message: 'Applicant Language Already Deleted!!.');
        }

        $applicantLanguage->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Applicant Language Deleted Successfully!!.', data: new ApplicantLanguagesResource($applicantLanguage));
    }

    public function getApplicantLanguageById(GetApplicantLanguageByIdRequest $request)
    {
        $data = $request->all();
        $applicantLanguage = ApplicantLanguage::where('id', $data['applicant_language_id'])->with('applicant', 'applicant.user', 'language')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Language Details.', data: new ApplicantLanguagesResource($applicantLanguage));
    }
}
