<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'company' => $this->company,
            'logo' => $this->logo,
            'job_title' => $this->job_title,
            'description' => $this->description,
            'job_type' => $this->job_type,
            'job_location' => $this->job_location,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'logo' => env("APP_URL") . "/uploads" . "/" . $this->logo,
            'applicant' => new ApplicantResource($this->whenLoaded('applicant')),
        ];
    }
}
