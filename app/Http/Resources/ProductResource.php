<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'description' => $this->description,
            'quantity' => $this->quantity > 0 ? 'In Stock' : 'Out of Stock',
            'size' => $this->size,
            'image_url' =>$this->image_url,
            'product_category_id' => $this->product_category_id,
            'status' => $this->status ? 'Show' : 'Hide',
            
        ];
    }
}
