<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewStatusResource extends JsonResource
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
            'comments' => $this->comments,
            'status' => $this->status,
            'interview_mail' => $this->interview_mail,
            'application' => new ApplicationResource($this->whenLoaded('application')),
        ];
    }
}