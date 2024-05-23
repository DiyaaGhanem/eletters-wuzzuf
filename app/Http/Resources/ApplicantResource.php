<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
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
            'name' => $this->name,
            'job_title' => $this->job_title,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'city' => $this->city,
            'bio' => $this->bio,
            'user' => new UserResource($this->whenLoaded('user')),
            'educations' => EducationResource::collection($this->whenLoaded('educations')),
            'experiences' => ExperienceResource::collection($this->whenLoaded('experiences')),
            'languages' => ApplicantLanguagesResource::collection($this->whenLoaded('languages')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
        ];
    }
}
