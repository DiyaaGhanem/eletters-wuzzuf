<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'cover_letters' => $this->cover_letters,
            'notice_period' => $this->notice_period,
            'application_date' => $this->application_date,
            'expected_salary' => $this->expected_salary,
            'answers' => $this->answers,
            'cv' => env("APP_URL") . "/uploads" . "/" . $this->cv,
            'candidate_profile_link' => $this->candidate_profile_link,
            'job' => new JobResource($this->whenLoaded('job')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'user' => new UserResource($this->whenLoaded('user')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
