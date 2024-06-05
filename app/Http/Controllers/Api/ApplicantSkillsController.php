<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApplicantSkillRequest;
use App\Http\Requests\Api\GetApplicantByIdRequest;
use App\Http\Requests\Api\GetApplicantSkillByIdRequest;
use App\Http\Requests\Api\GetUserByIdRequest;
use App\Http\Requests\Api\UpdateApplicantSkillRequest;
use App\Http\Resources\ApplicantResource;
use App\Http\Resources\ApplicantSkillsResource;
use App\Models\Applicant;
use App\Models\ApplicantSkill;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantSkillsController extends Controller
{
    use Responses;

    public function index()
    {
        $applicantSkills = ApplicantSkill::with(['applicant', 'applicant.user', 'skill'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: ApplicantSkillsResource::collection($applicantSkills), status: Response::HTTP_OK, message: 'All Applicant Skills.');
    }

    public function getApplicantSkillsByApplicant(GetApplicantByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->with('user', 'skills')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applicant Skills Details.', data: new ApplicantResource($applicant));
    }

    public function getApplicantSkillsByUserID(GetUserByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('user_id', $data['user_id'])->with('user', 'skills')->first();

        return $this->success(status: Response::HTTP_OK, message: 'All Applicant Skills Details.', data: new ApplicantResource($applicant));
    }

    public function createApplicantSkill(ApplicantSkillRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->first();
        $applicant->skills()->sync($data['skill_id']);

        $applicant->load('user', 'skills');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Skill Created Successfully!!.', data: new ApplicantResource($applicant));
    }

    public function updateApplicantSkill(UpdateApplicantSkillRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->first();
        $applicant->skills()->sync($data['skill_id']);

        $applicant->load('user', 'skills');
        return $this->success(status: Response::HTTP_OK, message: 'Applicant Skill Updated Successfully!!.', data: new ApplicantResource($applicant));
    }

    public function deleteApplicantSkill(GetApplicantSkillByIdRequest $request)
    {

        $data = $request->all();
        $applicantSkill = ApplicantSkill::find($data['applicant_skill_id']);

        $applicantSkill->load('applicant', 'applicant.user', 'skill');

        if (is_null($applicantSkill)) {
            return $this->error(status: Response::HTTP_OK, message: 'Applicant Skill Already Deleted!!.');
        }

        $applicantSkill->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Applicant Skill Deleted Successfully!!.', data: new ApplicantSkillsResource($applicantSkill));
    }

    public function getApplicantSkillById(GetApplicantSkillByIdRequest $request)
    {
        $data = $request->all();
        $applicantSkill = ApplicantSkill::where('id', $data['applicant_skill_id'])->with('applicant', 'applicant.user', 'skill')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Skill Details.', data: new ApplicantSkillsResource($applicantSkill));
    }
}
