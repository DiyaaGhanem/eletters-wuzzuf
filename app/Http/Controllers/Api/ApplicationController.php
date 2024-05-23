<?php

namespace App\Http\Controllers\Api;

use App\Traits\Responses;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\Api\ApplicationRequest;
use App\Http\Requests\Api\UpdateApplicationRequest;
use App\Http\Requests\Api\GetApplicationByIdRequest;
use App\Traits\UploadFilesTrait;

class ApplicationController extends Controller
{
    use Responses, UploadFilesTrait;

    public function index()
    {
        $applications = Application::with(['reviews', 'user', 'job'])->orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: ApplicationResource::collection($applications), status: Response::HTTP_OK, message: 'All Applications.');

    }

    public function createApplication(ApplicationRequest $request)
    {
        $data = $request->all();

        if (isset($data['cv'])) {
            $cv_new_name = $data['cv']->hashName();
            $data['cv']->move($this->createDirectory("applications/cvs"), $cv_new_name);
            $data['cv'] = "applications/cvs/" . $cv_new_name;
        }

        $application = Application::create($data);

        $application->load('user');

        return $this->success(status: Response::HTTP_OK, message: 'Application Created Successfully!!.', data: new ApplicationResource($application));
    }

    public function updateApplication(UpdateApplicationRequest $request)
    {
        $data = $request->all();
        $application = Application::findOrFail($data['application_id']);

        if ($request->hasFile('cv')) {
            $this->deleteFile($application->cv);

            $cv_new_name = $data['cv']->hashName();
            $data['cv']->move($this->createDirectory("applications/cvs"), $cv_new_name);
            $data['cv'] = "applications/cvs/" . $cv_new_name;
        }

        $application->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Application Updated Successfully!!.', data: new ApplicationResource($application));
    }

    public function softDeleteApplication(GetApplicationByIdRequest $request)
    {

        $data = $request->all();
        $application = Application::find($data['application_id']);

        if (is_null($application)) {
            return $this->error(status: Response::HTTP_OK, message: 'Application Already Deleted!!.');
        }

        $application->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Application Deleted Successfully!!.', data: new ApplicationResource($application));
    }

    public function restoreApplication(GetApplicationByIdRequest $request)
    {

        $data = $request->all();
        $application = Application::withTrashed()->find($data['application_id']);

        if (!is_null($application->deleted_at)) {
            $application->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Application Restored Successfully!!.', data: new ApplicationResource($application));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Application Already Restored!!.', data: new ApplicationResource($application));
    }

    public function getApplicationById(GetApplicationByIdRequest $request)
    {
        $data = $request->all();
        $application = Application::where('id', $data['application_id'])->with('job', 'user', 'reviews')->first();

        return $this->success(status: Response::HTTP_OK, message: 'Application Details.', data: new ApplicationResource($application));
    }
}
