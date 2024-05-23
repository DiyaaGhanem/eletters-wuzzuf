<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CorporateRequest;
use App\Http\Requests\Api\GetCorporateByIdRequest;
use App\Http\Requests\Api\UpdateCorporateRequest;
use App\Http\Resources\CorporateResource;
use App\Models\Corporate;
use App\Traits\Responses;
use App\Traits\UploadFilesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CorporateController extends Controller
{
    use Responses, UploadFilesTrait;

    public function index()
    {
        $corporates = Corporate::with('user')->orderBy('id', 'DESC')->paginate(10);
        
        return $this->successPaginated(data: CorporateResource::collection($corporates), status: Response::HTTP_OK, message: 'All Corporates.');
    }

    public function createCorporate(CorporateRequest $request)
    {
        $data = $request->all();

        $logo_new_name = $data['logo']->hashName();
        $data['logo']->move($this->createDirectory("corperates/logos"), $logo_new_name);
        $data['logo'] = "corperates/logos/" . $logo_new_name;

        $corporate = Corporate::create($data);
        $corporate->load('user');

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Created Successfully!!.', data: new CorporateResource($corporate));
    }

    public function updateCorporate(UpdateCorporateRequest $request)
    {
        $data = $request->all();
        $corporate = Corporate::findOrFail($data['corporate_id']);

        if ($request->hasFile('logo')) {
            $this->deleteFile($corporate->logo);

            $logo_new_name = $data['logo']->hashName();
            $data['logo']->move($this->createDirectory("corperates/logos"), $logo_new_name);
            $data['logo'] = "corperates/logos/" . $logo_new_name;
        }

        $corporate->update($data);
        $corporate->load('user');

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Updated Successfully!!.', data: new CorporateResource($corporate));
    }

    public function softDeleteCorporate(GetCorporateByIdRequest $request)
    {

        $data = $request->all();
        $corporate = Corporate::find($data['corporate_id']);

        if (is_null($corporate)) {
            return $this->error(status: Response::HTTP_OK, message: 'Corporate Already Deleted!!.');
        }

        $corporate->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Corporate Deleted Successfully!!.', data: new CorporateResource($corporate));
    }

    public function restoreCorporate(GetCorporateByIdRequest $request)
    {

        $data = $request->all();
        $corporate = Corporate::withTrashed()->find($data['corporate_id']);

        if (!is_null($corporate->deleted_at)) {
            $corporate->restore();
            return $this->success(status: Response::HTTP_OK, message: 'Corporate Restored Successfully!!.', data: new CorporateResource($corporate));
        }

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Already Restored!!.', data: new CorporateResource($corporate));
    }

    public function getCorporateById(GetCorporateByIdRequest $request)
    {
        $data = $request->all();
        $corporate = Corporate::with('user')->findOrFail($data['corporate_id']);

        return $this->success(status: Response::HTTP_OK, message: 'Corporate Details.', data: new CorporateResource($corporate));
    }
}
