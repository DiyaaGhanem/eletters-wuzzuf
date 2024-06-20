<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'department' => $this->department,
            'job_type' => $this->job_type,
            'job_location' => $this->job_location,
            'job_requirement' => $this->job_requirement,
            'job_level' => $this->job_level,
            'job_questions' => $this->job_questions,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'created_at' => $this->created_at,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'applications' => ApplicationResource::collection($this->whenLoaded('applications')),
            'corporate' => new CorporateResource($this->whenLoaded('corporate')),
            'applications_count' => $this->applications()->count(),
            'country' => new CountryResource($this->whenLoaded('country')),
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}
