<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'status' => $this->status,
            'notes' => $this->notes,
            'message' => $this->message,
            'application' => new ApplicationResource($this->whenLoaded('application')),
            'interview' => new InterviewResource($this->whenLoaded('interview')),
        ];
    }
}
