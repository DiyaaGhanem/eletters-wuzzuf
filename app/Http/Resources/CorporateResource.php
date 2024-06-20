<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CorporateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'logo' => env("APP_URL") . "/uploads" . "/" . $this->logo,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'jobs' => JobResource::collection($this->whenLoaded('jobs')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}