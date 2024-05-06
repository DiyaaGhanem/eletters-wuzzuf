<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetInterviewStatusByIdRequest;
use App\Http\Requests\Api\InterviewStatusRequest;
use App\Http\Requests\Api\UpdateInterviewStatusRequest;
use App\Http\Resources\InterviewStatusResource;
use App\Models\InterviewStatus;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InterviewStatusController extends Controller
{
    use Responses;

    public function index()
    {
        $interviewStatuses = InterviewStatus::with(['application'])->orderBy('id', 'DESC')->get();

        return $this->success(status: Response::HTTP_OK, message: 'All interview statuses.', data: InterviewStatusResource::collection($interviewStatuses));
    }

    public function createInterviewStatus(InterviewStatusRequest $request)
    {
        $data = $request->all();
        $interview = InterviewStatus::create($data);
        return $this->success(status: Response::HTTP_OK, message: 'Interview status Created Successfully!!.', data: new InterviewStatusResource($interview));
    }


    public function updateInteriewStatus(UpdateInterviewStatusRequest $request)
    {
        $data = $request->all();
        $interview = InterviewStatus::findOrFail($data['interview_status_id']);
        $interview->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Interview status Updated Successfully!!.', data: new InterviewStatusResource($interview));
    }


    public function softDeleteInteriewStatus(GetInterviewStatusByIdRequest $request)
    {

        $data = $request->all();
        $interview = InterviewStatus::find($data['interview_status_id']);

        if (is_null($interview)) {
            return $this->error(status: Response::HTTP_OK, message: 'Interview status Already Deleted!!.');
        }

        $interview->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Interview status Deleted Successfully!!.', data: new InterviewStatusResource($interview));
    }


    public function restoreInteriewStatus(GetInterviewStatusByIdRequest $request)
    {

        $data = $request->all();
        $interview = InterviewStatus::withTrashed()->find($data['interview_status_id']);

        if (!is_null($interview->deleted_at)) {
            $interview->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Interview status Restored Successfully!!.', data: new InterviewStatusResource($interview));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Interview status Already Restored!!.', data: new InterviewStatusResource($interview));
    }


    public function getInteriewStatusById(GetInterviewStatusByIdRequest $request)
    {
        $data = $request->all();
        $interview = InterviewStatus::where('id', $data['interview_status_id'])->with('application')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Interview status Details.', data: new InterviewStatusResource($interview));
    }
}
