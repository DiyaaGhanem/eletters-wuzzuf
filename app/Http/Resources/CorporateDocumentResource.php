<?php

namespace App\Http\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorporateDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $documentModel = Document::findOrFail($this->document_id);
        if ($documentModel->data_type == 'file') {
            $value = env("APP_URL") . "/uploads" . "/" . $this->value;
        } else {
            $value = $this->value;
        }
        return [
            'id' => $this->id,
            'value' => $value,
            'status' => $this->status ?? "Under Review",
            'corporate' => new CorporateResource($this->whenLoaded('corporate')),
            'document' => new DocumentResource($this->whenLoaded('document')),
        ];
    }
}
