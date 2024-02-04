<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecurringResource extends JsonResource
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
            'userId' => $this->user_id,
            'categoryId' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
            'category' => new CategoryResource($this->whenLoaded('category'))
        ];
    }
}
