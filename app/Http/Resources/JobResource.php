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
            'department' => $this->department,
            'job_type' => $this->job_type,
            'country' => $this->country,
            'job_location' => $this->job_location,
            'job_requirement' => $this->job_requirement,
            'job_level' => $this->job_level,
            'skills_keys' => $this->skills_keys,
            'job_questions' => $this->job_questions,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'corporate' => new CorporateResource($this->whenLoaded('corporate')),
        ];
    }
}
