<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EducationRequest;
use App\Http\Requests\Api\GetApplicantByIdRequest;
use App\Http\Requests\Api\GetEducationByIdRequest;
use App\Http\Requests\Api\UpdateEducationRequest;
use App\Http\Resources\ApplicantResource;
use App\Http\Resources\EducationResource;
use App\Models\Applicant;
use App\Models\Education;
use App\Traits\Responses;
use App\Traits\UploadFilesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantEducationController extends Controller
{
    use Responses, UploadFilesTrait;

    public function index()
    {
        $educations = Education::with(['applicant', 'applicant.user'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: EducationResource::collection($educations), status: Response::HTTP_OK, message: 'All Educations.');
    }

    public function getEducationsByApplicant(GetApplicantByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->with('user', 'educations')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applicant Educations Details.', data: new ApplicantResource($applicant));
    }

    public function createEducation(EducationRequest $request)
    {
        $data = $request->all();

        $logo_new_name = $data['logo']->hashName();
        $data['logo']->move($this->createDirectory("education/logos"), $logo_new_name);
        $data['logo'] = "education/logos/" . $logo_new_name;

        $education = Education::create($data);
        $education->load('applicant', 'applicant.user');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Education Created Successfully!!.', data: new EducationResource($education));
    }

    public function updateEducation(UpdateEducationRequest $request)
    {
        $data = $request->all();
        $education = Education::findOrFail($data['education_id']);

        if ($request->hasFile('logo')) {
            $this->deleteFile($education->logo);

            $logo_new_name = $data['logo']->hashName();
            $data['logo']->move($this->createDirectory("education/logos"), $logo_new_name);
            $data['logo'] = "education/logos/" . $logo_new_name;
        }

        $education->update($data);

        $education->load('applicant', 'applicant.user');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Education Updated Successfully!!.', data: new EducationResource($education));
    }

    public function softDeleteEducation(GetEducationByIdRequest $request)
    {

        $data = $request->all();
        $education = Education::find($data['education_id']);

        $education->load('applicant', 'applicant.user');

        if (is_null($education)) {
            return $this->error(status: Response::HTTP_OK, message: 'Applicant Education Already Deleted!!.');
        }

        $education->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Applicant Education Deleted Successfully!!.', data: new EducationResource($education));
    }

    public function restoreEducation(GetEducationByIdRequest $request)
    {

        $data = $request->all();
        $education = Education::withTrashed()->find($data['education_id']);

        $education->load('applicant', 'applicant.user');

        if (!is_null($education->deleted_at)) {
            $education->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Applicant Education Restored Successfully!!.', data: new EducationResource($education));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Education Already Restored!!.', data: new EducationResource($education));
    }

    public function getEducationById(GetEducationByIdRequest $request)
    {
        $data = $request->all();
        $education = Education::where('id', $data['education_id'])->with('applicant', 'applicant.user')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Education Details.', data: new EducationResource($education));
    }
}
