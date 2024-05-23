<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'parent_category' => new CategoryResource($this->whenLoaded('parent')),
            'sub_categories'  => CategoryResource::collection($this->whenLoaded('subCategories')),
            'jobs'  => JobResource::collection($this->whenLoaded('jobs')),
            'jobs_count' => $this->jobs()->count()
        ];
    }
}
