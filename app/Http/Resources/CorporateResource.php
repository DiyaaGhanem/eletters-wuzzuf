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
            'tax_register' => $this->tax_register,
            'commercial_record' => $this->commercial_record,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'logo' => env("APP_URL") . "/uploads/corperates/logos" . "/" . $this->logo,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'tax_register_document' => env("APP_URL") . "/uploads/corperates/documents" . "/" . $this->tax_register_document,
            'commercial_record_document' => env("APP_URL") . "/uploads/corperates/documents" . "/" . $this->commercial_record_document,
            'id_face' => env("APP_URL") . "/uploads/corperates/documents" . "/" . $this->id_face,
            'id_back' => env("APP_URL") . "/uploads/corperates/documents" . "/" . $this->id_back,
            'owner_title' => $this->owner_title,
            'user' => new UserResource($this->whenLoaded('user')),
            'jobs' => JobResource::collection($this->whenLoaded('jobs')),
        ];
    }
}