<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquityStatementResource extends JsonResource
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
            'type' => $this->type,
            'categoryId' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'week' => $this->week,
            'month' => $this->month,
            'year' => $this->year,
            'amount' => $this->amount,
            'category' => new CategoryResource($this->whenLoaded('category'))
        ];
    }
}
