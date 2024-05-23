<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApplicantRequest;
use App\Http\Requests\Api\GetApplicantByIdRequest;
use App\Http\Requests\Api\UpdateApplicantRequest;
use App\Http\Resources\ApplicantResource;
use App\Models\Applicant;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantController extends Controller
{
    use Responses;

    public function index()
    {
        $applicants = Applicant::with(['user'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: ApplicantResource::collection($applicants), status: Response::HTTP_OK, message: 'All Applicants.');
    }

    public function createApplicant(ApplicantRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::create($data);

        $applicant->load('user');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Created Successfully!!.', data: new ApplicantResource($applicant));
    }

    public function updateApplicant(UpdateApplicantRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::findOrFail($data['applicant_id']);
        $applicant->update($data);

        $applicant->load('user');

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Updated Successfully!!.', data: new ApplicantResource($applicant));
    }


    public function softDeleteApplicant(GetApplicantByIdRequest $request)
    {

        $data = $request->all();
        $applicant = Applicant::find($data['applicant_id']);

        $applicant->load('user');

        if (is_null($applicant)) {
            return $this->error(status: Response::HTTP_OK, message: 'Applicant Already Deleted!!.');
        }

        $applicant->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Applicant Deleted Successfully!!.', data: new ApplicantResource($applicant));
    }

    public function restoreApplicant(GetApplicantByIdRequest $request)
    {

        $data = $request->all();
        $applicant = Applicant::withTrashed()->find($data['applicant_id']);

        $applicant->load('user');

        if (!is_null($applicant->deleted_at)) {
            $applicant->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Applicant Restored Successfully!!.', data: new ApplicantResource($applicant));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Already Restored!!.', data: new ApplicantResource($applicant));
    }

    public function getApplicantById(GetApplicantByIdRequest $request)
    {
        $data = $request->all();
        $applicant = Applicant::where('id', $data['applicant_id'])->with('user', 'educations', 'experiences', 'languages', 'skills')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Applicant Details.', data: new ApplicantResource($applicant));
    }
}
