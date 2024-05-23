<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetSkillByIdRequest;
use App\Http\Requests\Api\SkillRequest;
use App\Http\Requests\Api\UpdateSkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SkillController extends Controller
{
    use Responses;

    public function index()
    {
        $skills = Skill::orderBy('id', 'DESC')->paginate(10);

        return $this->successPaginated(data: SkillResource::collection($skills), status: Response::HTTP_OK, message: 'All skills.');
    }

    public function createSkill(SkillRequest $request)
    {
        $data = $request->all();
        $skill = Skill::create($data);

        return $this->success(status: Response::HTTP_OK, message: 'Skill Created Successfully!!.', data: new SkillResource($skill));
    }

    public function updateSkill(UpdateSkillRequest $request)
    {
        $data = $request->all();
        $skill = Skill::where('id', $data['skill_id'])->first();
        $skill->update($data);

        return $this->success(status: Response::HTTP_OK, message: 'Skill Updated Successfully!!.', data: new SkillResource($skill));
    }

    public function deleteSkill(GetSkillByIdRequest $request)
    {
        $data = $request->all();
        $skill = Skill::find($data['skill_id']);

        if (is_null($skill)) {
            return $this->error(status: Response::HTTP_OK, message: 'Skill Already Deleted!!.');
        }

        $skill->delete();
        return $this->success(status: Response::HTTP_OK, message: 'Skill Deleted Successfully!!.', data: new SkillResource($skill));
    }

    public function getSkillById(GetSkillByIdRequest $request)
    {
        $data = $request->all();
        $skill = Skill::where('id', $data['skill_id'])->first();

        return $this->success(status: Response::HTTP_OK, message: 'Skill Details.', data: new SkillResource($skill));
    }
}