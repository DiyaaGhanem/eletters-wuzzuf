<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ExperienceRequest;
use App\Http\Requests\Api\GetApplicantByIdRequest;
use App\Http\Requests\Api\GetExperienceByIdRequest;
use App\Http\Requests\Api\GetUserByIdRequest;
use App\Http\Requests\Api\UpdateExperienceRequest;
use App\Http\Resources\ApplicantResource;
use App\Http\Resources\ExperienceResource;
use App\Models\Applicant;
use App\Models\Experience;
use App\Traits\Responses;
use App\Traits\UploadFilesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantExperienceController extends Controller
{
    use Responses, UploadFilesTrait;

    public function index()
    {
        $experiences = Experience::with(['applicant', 'applicant.user'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: ExperienceResource::collection($experiences), status: Response::HTTP_OK, message: 'All Experience.');
    }

    public function getExperiencesByApplicant(GetApplicantByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->with('user', 'experiences')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applicant Experiences Details.', data: new ApplicantResource($applicant));
    }

    public function getExperiencesByUserID(GetUserByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('user_id', $data['user_id'])->with('user', 'experiences')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applicant Experiences Details.', data: new ApplicantResource($applicant));
    }

    public function createExperience(ExperienceRequest $request)
    {
        $data = $request->all();

        $logo_new_name = $data['logo']->hashName();
        $data['logo']->move($this->createDirectory("experience/logos"), $logo_new_name);
        $data['logo'] = "experience/logos/" . $logo_new_name;

        $experience = Experience::create($data);
        $experience->load('applicant', 'applicant.user');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Experience Created Successfully!!.', data: new ExperienceResource($experience));
    }

    public function updateExperience(UpdateExperienceRequest $request)
    {
        $data = $request->all();
        $experience = Experience::findOrFail($data['experience_id']);

        if ($request->hasFile('logo')) {
            $this->deleteFile($experience->logo);

            $logo_new_name = $data['logo']->hashName();
            $data['logo']->move($this->createDirectory("experience/logos"), $logo_new_name);
            $data['logo'] = "experience/logos/" . $logo_new_name;
        }

        $experience->update($data);

        $experience->load('applicant', 'applicant.user');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Experience Updated Successfully!!.', data: new ExperienceResource($experience));
    }

    public function softDeleteExperience(GetExperienceByIdRequest $request)
    {

        $data = $request->all();
        $experience = Experience::find($data['experience_id']);

        $experience->load('applicant', 'applicant.user');

        if (is_null($experience)) {
            return $this->error(status: Response::HTTP_OK, message: 'Applicant Experience Already Deleted!!.');
        }

        $experience->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Applicant Experience Deleted Successfully!!.', data: new ExperienceResource($experience));
    }

    public function restoreExperience(GetExperienceByIdRequest $request)
    {

        $data = $request->all();
        $experience = Experience::withTrashed()->find($data['experience_id']);

        $experience->load('applicant', 'applicant.user');

        if (!is_null($experience->deleted_at)) {
            $experience->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Applicant Experience Restored Successfully!!.', data: new ExperienceResource($experience));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Experience Already Restored!!.', data: new ExperienceResource($experience));
    }

    public function getExperienceById(GetExperienceByIdRequest $request)
    {
        $data = $request->all();
        $experience = Experience::where('id', $data['experience_id'])->with('applicant', 'applicant.user')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Experience Details.', data: new ExperienceResource($experience));
    }
}
