<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantSkillsResource extends JsonResource
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
            'applicant' => new ApplicantResource($this->whenLoaded('applicant')),
            'skill' => new SkillResource($this->whenLoaded('skill')),
        ];
    }
}
