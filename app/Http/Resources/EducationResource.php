<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'university' => $this->university,
            'major' => $this->major,
            'grade' => $this->grade,
            'degree' => $this->degree,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'logo' => env("APP_URL") . "/uploads" . "/" . $this->logo,
            'applicant' => new ApplicantResource($this->whenLoaded('applicant')),
        ];
    }
}
