<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetInterviewByIdRequest;
use App\Http\Requests\Api\InterviewRequest;
use App\Http\Requests\Api\UpdateInterviewRequest;
use App\Http\Resources\InterviewResource;
use App\Models\Interview;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InterviewController extends Controller
{
    use Responses;

    public function index()
    {
        $interviews = Interview::with(['review', 'review.application.user'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: InterviewResource::collection($interviews), status: Response::HTTP_OK, message: 'All interviews.');
    }

    public function createInterview(InterviewRequest $request)
    {
        $data = $request->all();
        $interview = Interview::create($data);

        $interview->load('review', 'review.application', 'review.application.user');

        return $this->success(status: Response::HTTP_OK, message: 'Interview Created Successfully!!.', data: new InterviewResource($interview));
    }

    public function updateInterview(UpdateInterviewRequest $request)
    {
        $data = $request->all();
        $interview = Interview::findOrFail($data['interview_id']);
        $interview->update($data);
        $interview->load('review', 'review.application', 'review.application.user');

        return $this->success(status: Response::HTTP_OK, message: 'Interview Updated Successfully!!.', data: new InterviewResource($interview));
    }

    public function softDeleteInterview(GetInterviewByIdRequest $request)
    {

        $data = $request->all();
        $interview = Interview::find($data['interview_id']);

        if (is_null($interview)) {
            return $this->error(status: Response::HTTP_OK, message: 'Interview Already Deleted!!.');
        }

        $interview->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Interview Deleted Successfully!!.', data: new InterviewResource($interview));
    }

    public function restoreInterview(GetInterviewByIdRequest $request)
    {

        $data = $request->all();
        $interview = Interview::withTrashed()->find($data['interview_id']);

        if (!is_null($interview->deleted_at)) {
            $interview->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Interview Restored Successfully!!.', data: new InterviewResource($interview));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Interview Already Restored!!.', data: new InterviewResource($interview));
    }

    public function getInterviewById(GetInterviewByIdRequest $request)
    {
        $data = $request->all();
        $interview = Interview::where('id', $data['interview_id'])->with(['review', 'review.application', 'review.application.user'])->first();

        return $this->success(status: Response::HTTP_OK, message: 'Interview Details.', data: new InterviewResource($interview));
    }
}
