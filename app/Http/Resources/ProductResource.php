<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'imageUrls' => $this->imageUrls,
            'category' => $this->category,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discountedPrice' => $this->discountedPrice,
            'discountedPersent' => $this->discountedPersent,
            'description' => $this->description,
            'created_at' => (new Carbon($this->created_at)) -> format('Y-m-d'),
        ];
    }
}
