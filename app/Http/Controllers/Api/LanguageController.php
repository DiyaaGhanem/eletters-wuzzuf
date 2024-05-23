<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetLanguageByIdRequest;
use App\Http\Requests\Api\LanguageRequest;
use App\Http\Requests\Api\UpdateLanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LanguageController extends Controller
{
    use Responses;

    public function index()
    {
        $languages = Language::orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: LanguageResource::collection($languages), status: Response::HTTP_OK, message: 'All Languages.');
    }

    public function createLanguage(LanguageRequest $request)
    {
        $data = $request->all();
        $language = Language::create($data);

        return $this->success(status: Response::HTTP_OK, message: 'Language Created Successfully!!.', data: new LanguageResource($language));
    }

    public function updateLanguage(UpdateLanguageRequest $request)
    {
        $data = $request->all();
        $language = Language::where('id', $data['language_id'])->first();
        $language->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Language Updated Successfully!!.', data: new LanguageResource($language));
    }

    public function deleteLanguage(GetLanguageByIdRequest $request)
    {
        $data = $request->all();
        $language = Language::find($data['language_id']);

        if (is_null($language)) {
            return $this->error(status: Response::HTTP_OK, message: 'Language Already Deleted!!.');
        }

        $language->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Language Deleted Successfully!!.', data: new LanguageResource($language));
    }

    public function getLanguageById(GetLanguageByIdRequest $request)
    {
        $data = $request->all();
        $language = Language::where('id', $data['language_id'])->first();

        return $this->success(status: Response::HTTP_OK, message: 'Language Details.', data: new LanguageResource($language));
    }
}
