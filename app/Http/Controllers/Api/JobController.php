<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetJobByIdRequest;
use App\Http\Requests\Api\JobRequest;
use App\Http\Requests\Api\UpdateJobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class JobController extends Controller
{
    use Responses;

    public function index()
    {
        $jobs = Job::with(['categories', 'skills', 'corporate', 'corporate.user', 'country', 'city'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: JobResource::collection($jobs), status: Response::HTTP_OK, message: 'All Jobs.');
    }

    public function jobsCount()
    {
        $jobsCount = Job::where('status', 'Published')->count();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Number Of All Jobs.',
            'data' =>  $jobsCount
        ]);
    }

    public function createJob(JobRequest $request)
    {
        $data = $request->all();
        $job = Job::create($data);
        $job->categories()->attach($data['category_id']);
        $job->skills()->attach($data['skill_id']);
        $job->load(['categories', 'skills', 'corporate', 'corporate.user', 'country', 'city']);
        return $this->success(status: Response::HTTP_OK, message: 'Job Created Successfully!!.', data: new JobResource($job));
    }

    public function updateJob(UpdateJobRequest $request)
    {
        $data = $request->all();
        $job = Job::findOrFail($data['job_id']);
        $job->update($data);
        $job->categories()->sync($data['category_id']);
        $job->skills()->sync($data['skill_id']);

        $job->load(['categories', 'skills', 'corporate', 'corporate.user', 'country', 'city']);
        return $this->success(status: Response::HTTP_OK, message: 'Job Updated Successfully!!.', data: new JobResource($job));
    }

    public function softDeleteJob(GetJobByIdRequest $request)
    {

        $data = $request->all();
        $job = Job::find($data['job_id']);

        if (is_null($job)) {
            return $this->error(status: Response::HTTP_OK, message: 'Job Already Deleted!!.');
        }

        $job->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Job Deleted Successfully!!.', data: new JobResource($job));
    }

    public function restoreJob(GetJobByIdRequest $request)
    {

        $data = $request->all();
        $job = Job::withTrashed()->find($data['job_id']);

        if (!is_null($job->deleted_at)) {
            $job->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Job Restored Successfully!!.', data: new JobResource($job));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Job Already Restored!!.', data: new JobResource($job));
    }

    public function getJobById(GetJobByIdRequest $request)
    {
        $data = $request->all();
        $job = Job::where('id', $data['job_id'])->with('categories', 'skills', 'corporate', 'corporate.user', 'country', 'city')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Job Details.', data: new JobResource($job));
    }

    public function getApplicationsByJobId(GetJobByIdRequest $request)
    {
        $data = $request->all();
        $job = Job::where('id', $data['job_id'])->with('applications', 'applications.user', 'country', 'city')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Job Details.', data: new JobResource($job));
    }
}
